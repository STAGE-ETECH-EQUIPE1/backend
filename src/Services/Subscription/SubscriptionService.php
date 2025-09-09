<?php

namespace App\Services\Subscription;

use App\DTO\Payment\CyberSourcePaymentDataDTO;
use App\DTO\Subscription\SubscriptionDTO;
use App\Entity\Auth\Client;
use App\Entity\Subscription\Pack;
use App\Entity\Subscription\Subscription;
use App\Enum\SubscriptionStatus;
use App\Exception\ResourceNotFoundException;
use App\Repository\Auth\ClientRepository;
use App\Repository\Payment\PaymentRepository;
use App\Repository\Subscription\PackRepository;
use App\Repository\Subscription\ServiceRepository;
use App\Repository\Subscription\SubscriptionRepository;
use App\Response\Payment\SecureAcceptanceResponseDTO;
use App\Services\Client\ClientServiceInterface;
use App\Services\Payment\MainPayment\MainPaymentServiceInterface;
use App\Services\User\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class SubscriptionService implements SubscriptionServiceInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ServiceRepository $serviceRepository,
        private readonly PaymentRepository $paymentRepository,
        private readonly PackRepository $packRepository,
        private readonly ClientRepository $clientRepository,
        private readonly SubscriptionRepository $subscriptionRepository,
        private readonly UserServiceInterface $userService,
        private readonly MainPaymentServiceInterface $mainPaymentService,
        private readonly ClientServiceInterface $clientService,
    ) {
    }

    public function createSubscription(SubscriptionDTO $subscriptionDTO): Subscription
    {
        $client = $this->clientRepository->find($subscriptionDTO->getClientId());
        if (!$client) {
            throw new \Exception('Client not found');
        }

        $subscription = $this->subscriptionRepository->findOneBy(['client' => $client]) ?? new Subscription();

        $subscription->setName($subscriptionDTO->getName());
        $subscription->setReference($subscriptionDTO->getReference());
        $subscription->setStatus($subscriptionDTO->getStatus());
        $subscription->setStartedAt($subscriptionDTO->getStartedAt());
        $subscription->setEndedAt($subscriptionDTO->getEndedAt());
        if ($subscriptionDTO->getPaymentId()) {
            $payment = $this->paymentRepository->find($subscriptionDTO->getPaymentId());
            if ($payment) {
                $subscription->setPayment($payment);
            }
        }

        if ($subscriptionDTO->getPackId()) {
            $pack = $this->packRepository->find($subscriptionDTO->getPackId());
            $subscription->setPack($pack);
        }

        $client = $this->clientRepository->find($subscriptionDTO->getClientId());
        if (!$client) {
            throw new \Exception('Client not found for id '.$subscriptionDTO->getClientId());
        }
        $subscription->setClient($client);

        $services = $this->serviceRepository->findBy(['id' => $subscriptionDTO->getServices()]);
        foreach ($services as $service) {
            $subscription->addService($service);
        }
        $this->em->persist($subscription);
        $this->em->flush();

        return $subscription;
    }

    public function resetSubscriptionForCurrentUser(): void
    {
        $subscription = $this->clientService->getSubscriptionForConnectedClient();
        if ($subscription) {
            $subscription->setStatus(SubscriptionStatus::EXPIRED);
        }
    }

    public function initializeSubscriptionFromPack(Pack $pack, CyberSourcePaymentDataDTO $cyberSourcePaymentDataDTO): Subscription
    {
        /** @var Client $client */
        $client = $this->userService->getConnectedUser()->getClient();
        $subscription = (new Subscription())
            ->setReference((string) $cyberSourcePaymentDataDTO->getReferenceNumber())
            ->setName((string) $pack->getName())
            ->setStatus(SubscriptionStatus::PENDING)
            ->setStartedAt($pack->getStartedAt() ?? new \DateTimeImmutable())
            ->setEndedAt($pack->getExpiredAt() ?? new \DateTimeImmutable())
            ->setClient($client)
            ->setPack($pack)
        ;

        $this->em->persist($subscription);
        $this->em->flush();

        return $subscription;
    }

    public function updateSubscriptionAfterPayment(SecureAcceptanceResponseDTO $response): Subscription
    {
        $payment = $this->mainPaymentService->initializePaymentFromResponseDTO($response);

        /** @var ?Subscription $subscription */
        $subscription = $this->subscriptionRepository->findOneBy([
            'reference' => $response->getReqReferenceNumber(),
        ]);

        if ($subscription) {
            $subscription->setPayment($payment);

            switch ($response->getDecision()) {
                case 'ERROR':
                    $subscription->setStatus(SubscriptionStatus::INACTIVE);
                    break;
                case 'ACCEPT':
                    $subscription->setStatus(SubscriptionStatus::ACTIVE);
                    break;
                default:
                    $subscription->setStatus(SubscriptionStatus::EXPIRED);
                    break;
            }

            $this->em->persist($subscription);
            $this->em->flush();

            return $subscription;
        }

        throw new ResourceNotFoundException('SUBSCRIPTION_NOT_FOUND');
    }

    public function makeFreePackForConnectedUser(): Subscription
    {
        $this->resetSubscriptionForCurrentUser();

        /** @var Pack $pack */
        $pack = $this->packRepository->getFreePack();

        /** @var Client $client */
        $client = $this->userService->getConnectedUser()->getClient();

        $subscription = (new Subscription())
            ->setReference(uniqid('ORDER-1-', true))
            ->setName((string) $pack->getName())
            ->setStatus(SubscriptionStatus::ACTIVE)
            ->setStartedAt($pack->getStartedAt() ?? new \DateTimeImmutable())
            ->setEndedAt($pack->getExpiredAt() ?? new \DateTimeImmutable())
            ->setClient($client)
            ->setPack($pack)
        ;

        $this->em->persist($subscription);
        $this->em->flush();

        return $subscription;
    }
}

<?php

namespace App\Services\Subscription;

use App\DTO\Subscription\SubscriptionDTO;
use App\DTO\Subscription\SubscriptionStatus;
use App\Entity\Subscription\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Subscription\ServiceRepository;
use App\Repository\Payment\PaymentRepository;
use App\Repository\Subscription\SubscriptionRepository;
use App\Repository\Auth\ClientRepository;

class SubscriptionService implements SubscriptionServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private ServiceRepository $serviceRepository,
        private PaymentRepository $paymentRepository,
        private ClientRepository $clientRepository,
        private SubscriptionRepository $subscriptionRepository
    ) {}

    public function createSubscription(SubscriptionDTO $subscriptionDTO): Subscription
    {
        $services = $this->serviceRepository->findBy(['id' => $subscriptionDTO->getServices()]);

        $subscription = new Subscription();
        $subscription->setReference($subscriptionDTO->getReference() ?? '');
        $subscription->setStatus($subscriptionDTO->getStatus() ?? SubscriptionStatus::ACTIVE);

        if ($subscriptionDTO->getStartedAt()) {
            $subscription->setStartedAt($subscriptionDTO->getStartedAt());
        }
        if ($subscriptionDTO->getEndedAt()) {
            $subscription->setEndedAt($subscriptionDTO->getEndedAt());
        }
        if ($subscriptionDTO->getPaymentId()) {
            $payment = $this->paymentRepository->find($subscriptionDTO->getPaymentId());
            if ($payment)
                $subscription->setPayment($payment);
        }
        
        $client = $this->clientRepository->find($subscriptionDTO->getClientId());
        if (!$client) {
            throw new \Exception("Client not found for id " . $subscriptionDTO->getClientId());
        }
        $subscription->setClient($client);

        foreach ($services as $service) {
            $subscription->addService($service);
        }

        $this->em->persist($subscription);
        $this->em->flush();

        return $subscription;
    }
}

<?php

namespace App\Services\Subscription;

use App\DTO\Subscription\SubscriptionDTO;
use App\Entity\Subscription\Subscription;
use App\Repository\Auth\ClientRepository;
use App\Repository\Payment\PaymentRepository;
use App\Repository\Subscription\ServiceRepository;
use App\Repository\Subscription\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;

class SubscriptionService implements SubscriptionServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private ServiceRepository $serviceRepository,
        private PaymentRepository $paymentRepository,
        private ClientRepository $clientRepository,
        private SubscriptionRepository $subscriptionRepository,
    ) {
    }

    public function createSubscription(SubscriptionDTO $subscriptionDTO): Subscription
    {
        $client = $this->clientRepository->find($subscriptionDTO->getClientId());
        if (!$client) {
            throw new \Exception('Client not found');
        }

        $subscription = $this->subscriptionRepository->findOneBy(['client' => $client]) ?? new Subscription();

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
}

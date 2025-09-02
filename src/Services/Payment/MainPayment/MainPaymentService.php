<?php

namespace App\Services\Payment\MainPayment;

use App\Entity\Payment\Payment;
use App\Response\Payment\SecureAcceptanceResponseDTO;
use Doctrine\ORM\EntityManagerInterface;

class MainPaymentService implements MainPaymentServiceInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function savePaymentFromResponseDTO(SecureAcceptanceResponseDTO $response): Payment
    {
        $payment = (new Payment())
            ->setIsRefunded(false)
            ->setPostalCode($response->getReqBillToAddressPostalCode())
            ->setCountryCode($response->getReqBillToAddressCountry())
            ->setCurrency($response->getReqCurrency())
            ->setPrice($response->getReqAmount())
            ->setFullName("{$response->getReqBillToForename()} {$response->getReqBillToSurname()}")
            ->setAddress($response->getReqBillToAddressLine1())
            ->setCity($response->getReqBillToAddressCity())
            ->setAddress($response->getReqBillToEmail())
            ->setTransactionId($response->getTransactionId())
            ->setDecision($response->getDecision())
            ->setCustomerIpAddress($response->getReqCustomerIpAddress())
            ->setBillToCompanyName($response->getReqBillToCompanyName())
            ->setFee('0')
            ->setTax(0)
            ->setPaymentMethod($response->getReqPaymentMethod())
            ->setTransactionType($response->getReqTransactionType())
            ->setReferenceNumber($response->getReqReferenceNumber())
            ->setCardNumber($response->getReqCardNumber())
            ->setCardType($response->getReqCardType())
            ->setMessage($response->getMessage())
        ;
        $this->entityManager->persist($payment);
        $this->entityManager->flush();

        return $payment;
    }
}

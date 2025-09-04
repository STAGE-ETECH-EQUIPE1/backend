<?php

namespace App\Services\Payment\CyberSource;

use App\DTO\Payment\CyberSourcePaymentDataDTO;
use App\Entity\Auth\Client;
use App\Exception\ResourceNotFoundException;
use App\Repository\Payment\PaymentRepository;
use App\Repository\Subscription\PackRepository;
use App\Response\Payment\PaymentResponse;
use App\Services\Subscription\SubscriptionServiceInterface;
use App\Services\User\UserServiceInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CyberSourceSecureAcceptance implements CybersourceSecureAcceptanceInterface
{
    private const string SIGNED_FIELDS_PAYMENT = 'access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,payment_method,merchant_defined_data1,merchant_id,customer_ip_address';

    private const string UNSIGNED_FIELDS_PAYMENT = 'bill_to_forename,bill_to_surname,bill_to_company_name,bill_to_email,bill_to_address_line1,bill_to_address_postal_code,bill_to_address_country,bill_to_phone,bill_to_zip,bill_to_address_city';

    public function __construct(
        #[Autowire('%app.cybersource_merchant_id%')]
        private readonly string $merchantId,
        #[Autowire('%app.cybersource_acces_key%')]
        private readonly string $accessKey,
        #[Autowire('%app.cybersource_secret_key%')]
        private readonly string $secretKey,
        #[Autowire('%app.cybersource_profile_id%')]
        private readonly string $profileId,
        #[Autowire('%app.cybersource_checkout_url%')]
        private readonly string $checkoutUrl,
        private readonly PaymentRepository $paymentRepository,
        private readonly PackRepository $packRepository,
        private readonly UserServiceInterface $userService,
        private readonly SubscriptionServiceInterface $subscriptionService,
    ) {
    }

    public function preparePaymentData(CyberSourcePaymentDataDTO $paymentDTO): array
    {
        return [
            $this->buildDataToForm($paymentDTO),
            $this->checkoutUrl,
        ];
    }

    public function getPaymentResumeResponsefromArrayQuery(array $query): PaymentResponse
    {
        $payment = $this->paymentRepository->findOneByTransactionIdAndReference(
            $query['referenceDevis'] ?? '',
            $query['reference'] ?? ''
        );
        if ($payment) {
            return (new PaymentResponse())->fromPayment($payment);
        }
        throw new ResourceNotFoundException('PAYMENT_NOT_FOUND_EXCEPTION');
    }

    public function buildDataForPaymentProcessWithPackId(int $id): CyberSourcePaymentDataDTO
    {
        $user = $this->userService->getConnectedUser();
        /** @var Client $client */
        $client = $user->getClient();
        $pack = $this->packRepository->findOneById($id);

        if ($pack) {
            $cybersourcePaymentDTO = new CyberSourcePaymentDataDTO(
                amount: (string) $pack->getPrice(),
                transactionUuid: uniqid('txn_', true),
                transactionType: 'authorization',
                referenceNumber: uniqid("ORDER-$id-", true),
                billToForename: $user->getFullName() ?? '',
                billToSurname: '',
                billToCompanyName: $client->getCompanyName(),
                billToEmail: $user->getEmail(),
                billToAddressLine1: '',
                billToAddressCountry: '',
                billToAddressCity: '',
                billToZip: '',
                billToPhone: $user->getPhone(),
                billToAddressPostalCode: '',
                currency: 'EUR',
            );
            $this->subscriptionService->initializeSubscriptionFromPack($pack, $cybersourcePaymentDTO);

            return $cybersourcePaymentDTO;
        }

        throw new ResourceNotFoundException('PACK_NOT_FOUND_EXCEPTION');
    }

    private function buildDataToForm(CyberSourcePaymentDataDTO $paymentDTO): array
    {
        $transactionUuid = $paymentDTO->getTransactionUuid();
        $signedDateTime = gmdate("Y-m-d\TH:i:s\Z");

        $data = [
            // Champs obligatoires signés
            'access_key' => $this->accessKey,
            'profile_id' => $this->profileId,
            'transaction_uuid' => $transactionUuid,
            'signed_field_names' => self::SIGNED_FIELDS_PAYMENT,
            'unsigned_field_names' => self::UNSIGNED_FIELDS_PAYMENT,
            'signed_date_time' => $signedDateTime,
            'locale' => $paymentDTO->locale,
            'transaction_type' => $paymentDTO->transactionType,
            'reference_number' => $paymentDTO->getReferenceNumber(),
            'amount' => $paymentDTO->getFormattedAmount(),
            'currency' => $paymentDTO->currency,
            'payment_method' => $paymentDTO->paymentMethod,
            'merchant_defined_data1' => $paymentDTO->merchantDefinedData1,
            'merchant_id' => $this->merchantId,
            'customer_ip_address' => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',

            // Champs non signés - Informations de facturation
            'bill_to_forename' => $paymentDTO->billToForename ?? '',
            'bill_to_surname' => $paymentDTO->billToSurname ?? '',
            'bill_to_company_name' => $paymentDTO->billToCompanyName ?? '',
            'bill_to_email' => $paymentDTO->billToEmail ?? '',
            'bill_to_address_line1' => $paymentDTO->billToAddressLine1 ?? '',
            'bill_to_address_city' => $paymentDTO->billToAddressCity ?? '',
            'bill_to_address_postal_code' => $paymentDTO->billToAddressPostalCode ?? '',
            'bill_to_address_country' => $paymentDTO->billToAddressCountry,
            'bill_to_phone' => $paymentDTO->billToPhone ?? '',
            'bill_to_zip' => $paymentDTO->billToZip ?? '',
        ];

        // Ajout de la signature
        $data['signature'] = $this->signData($data);

        return $data;
    }

    /**
     * Génère la signature HMAC-SHA256 pour les données.
     */
    private function signData(array $data): string
    {
        if (!isset($data['signed_field_names'])) {
            throw new \InvalidArgumentException('signed_field_names is required for signature generation');
        }

        $signedFieldNames = explode(',', $data['signed_field_names']);
        $dataToSign = [];

        foreach ($signedFieldNames as $field) {
            $field = trim($field);
            if (isset($data[$field])) {
                $dataToSign[] = $field.'='.$data[$field];
            } else {
                throw new \InvalidArgumentException("Missing required signed field: {$field}");
            }
        }

        $stringToSign = implode(',', $dataToSign);
        $signature = base64_encode(hash_hmac('sha256', $stringToSign, $this->secretKey, true));

        return $signature;
    }
}

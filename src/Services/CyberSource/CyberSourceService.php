<?php

namespace App\Services\CyberSource;

use App\Request\Payment\CyberSourcePaymentRequest;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CyberSourceService implements CyberSourceServiceInterface
{
    private const string REQUEST_METHOD = 'POST';
    private string $paymentPath;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        #[Autowire('%app.cybersource_api_endpoint%')]
        private readonly string $cyberSourceApiEndpoint,
        #[Autowire('%app.cybersource_merchant_id%')]
        private readonly string $cyberSourceMerchantId,
        #[Autowire('%app.cybersource_api_key_id%')]
        private readonly string $cyberSourceApiKeyId,
        #[Autowire('%app.cybersource_secret_key%')]
        private readonly string $cyberSourceSecretKey,
    ) {
        $this->paymentPath = "{$this->cyberSourceApiEndpoint}/pts/v2/payments/";
    }

    public function processPayment(CyberSourcePaymentRequest $request): array
    {
        $payload = json_encode($this->buildCyberSourceBody($request));
        $date = date('D, d M Y H:i:s').' GMT';

        $response = $this->httpClient->request(
            self::REQUEST_METHOD,
            $this->paymentPath,
            [
                'headers' => [
                    ...$this->generateHeaders((string) $payload, $date),
                    // 'signature' => $this->generateSignature((string) $payload, $date),
                ],
                'json' => $this->buildCyberSourceBody($request),
            ]
        );

        return $response->toArray();
    }

    private function buildCyberSourceBody(CyberSourcePaymentRequest $request): array
    {
        return [
            'clientReferenceInformation' => [
                'code' => $request->getOrderId(),
            ],
            'paymentInformation' => [
                'card' => [
                    'number' => $request->getCard()->getNumber(),
                    'expirationMonth' => $request->getCard()->getExpMonth(),
                    'expirationYear' => $request->getCard()->getExpYear(),
                ],
            ],
            'orderInformation' => [
                'amountDetails' => [
                    'totalAmount' => $request->getAmount(),
                    'currency' => $request->getCurrency(),
                ],
                'billTo' => [
                    'firstName' => $request->getBilling()->getFirstName(),
                    'lastName' => $request->getBilling()->getLastName(),
                    'address1' => $request->getBilling()->getAddress(),
                    'locality' => $request->getBilling()->getCity(),
                    'administrativeArea' => $request->getBilling()->getAdministrativeArea(),
                    'postalCode' => $request->getBilling()->getPostalCode(),
                    'country' => $request->getBilling()->getCountry(),
                    'email' => $request->getBilling()->getEmail(),
                    'phoneNumber' => $request->getBilling()->getPhoneNumber(),
                ],
            ],
        ];
    }

    private function generateHeaders(string $payload, string $formattedDate): array
    {
        return [
            'v-c-merchant-id' => $this->cyberSourceMerchantId,
            'v-c-date' => $formattedDate,
            'host' => parse_url($this->cyberSourceApiEndpoint, PHP_URL_HOST),
            // 'digest' => 'SHA-256='.base64_encode(hash('sha256', $payload, true)),
            'digest' => '',
        ];
    }

    private function generateSignature(string $payload, string $formattedDate): string
    {
        $digest = 'SHA-256='.base64_encode(hash('sha256', $payload, true));
        $signatureString = implode("\n", [
            'host: '.parse_url($this->cyberSourceApiEndpoint, PHP_URL_HOST),
            "date: {$formattedDate}",
            'request-target: '.strtolower(self::REQUEST_METHOD).' '.$this->paymentPath,
            "digest: {$digest}",
        ]);
        $signatureBytes = hash_hmac(
            'sha256',
            $signatureString,
            $this->cyberSourceSecretKey,
            true
        );
        $signatureBytes = base64_encode($signatureBytes);

        // return <<<SIGNATURE
        // keyid="{$this->cyberSourceApiKeyId}", algorithm="HmacSHA256", headers="host v-c-date request-target digest v-c-merchant-id", signature="{$signatureBytes}"
        // SIGNATURE;
        return <<<SIGNATURE
        keyid="{$this->cyberSourceApiKeyId}", algorithm="HmacSHA256", headers="host v-c-date request-target digest v-c-merchant-id", signature="{$signatureBytes}"
        SIGNATURE;
    }
}

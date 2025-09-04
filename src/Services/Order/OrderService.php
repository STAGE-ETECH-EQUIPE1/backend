<?php

namespace App\Services\Order;

use App\DTO\Payment\CyberSourcePaymentDataDTO;
use App\Entity\Subscription\Order;

class OrderService implements OrderServiceInterface
{
    public function prepareOrderFromCyberSourcePayment(CyberSourcePaymentDataDTO $cyberSourcePaymentDataDTO): Order
    {
        return (new Order())
            ->setCreatedAt(new \DateTimeImmutable())
        ;
    }
}

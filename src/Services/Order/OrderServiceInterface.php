<?php

namespace App\Services\Order;

use App\DTO\Payment\CyberSourcePaymentDataDTO;
use App\Entity\Subscription\Order;

interface OrderServiceInterface
{
    /**
     * Prepare Order from payment.
     */
    public function prepareOrderFromCyberSourcePayment(CyberSourcePaymentDataDTO $cyberSourcePaymentDataDTO): Order;
}

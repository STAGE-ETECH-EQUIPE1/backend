<?php

namespace App\Mapper\Subscription;

use App\DTO\Subscription\ServiceDTO;
use App\Request\Subscription\ServiceRequest;

class ServiceMapper
{
    public static function fromRequest(ServiceRequest $serviceRequest): ServiceDTO
    {
        return new ServiceDTO(
            $serviceRequest->getName(),
            $serviceRequest->getPrice(),
            $serviceRequest->getToken(),
        );
    }
}
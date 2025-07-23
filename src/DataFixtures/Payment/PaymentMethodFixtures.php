<?php

namespace App\DataFixtures\Payment;

use App\Entity\Payment\PaymentMethod;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaymentMethodFixtures extends Fixture
{
    public function getData(): array
    {
        return [
            [
                'name' => 'Visa',
                'code' => 'visa',
            ], [
                'name' => 'Mastercard',
                'code' => 'mastercard',
            ], [
                'name' => 'PayPal',
                'code' => 'paypal',
            ], [
                'name' => 'MVola',
                'code' => 'mvola',
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $data) {
            $method = (new PaymentMethod())
                ->setName($data['name'])
                ->setRef($data['code']);
            $manager->persist($method);
            $this->addReference('payment_method_'.$data['code'], $method);
        }
        $manager->flush();
    }
}

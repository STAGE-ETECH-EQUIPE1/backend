<?php

namespace App\DataFixtures\Subscription;

use App\DataFixtures\FakerTrait;
use App\Entity\Subscription\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class ServiceFixtures extends Fixture
{
    use FakerTrait;

    private function getData(): array
    {
        $randomPrice = $this->getFaker()->randomFloat(2, 10, 50).'';

        return
        [
            // VIP
            ['code' => 'CREATION-LOGO-VIP', 'name' => 'Création Logo', 'token' => 20, 'price' => $randomPrice, 'token_name' => 'logo_generation_tokens'],
            ['code' => 'CREATION-COMPANY-NAME-VIP', 'name' => 'Création Company Name', 'token' => 20, 'price' => $randomPrice, 'token_name' => 'company_name_tokens'],
            ['code' => 'CREATION-VALUES-VIP', 'name' => 'Création Value', 'token' => 20, 'price' => $randomPrice, 'token_name' => 'values_tokens'],
            ['code' => 'CREATION-TON-VOICE-VIP', 'name' => 'Création Ton Voice', 'token' => 20, 'price' => $randomPrice, 'token_name' => 'ton_voice_tokens'],
            ['code' => 'CREATION-TYPOGRAPHIE-VIP', 'name' => 'Création Typographie', 'token' => 20, 'price' => $randomPrice, 'token_name' => 'typography_tokens'],
            ['code' => 'CREATION-SLOGAN-VIP', 'name' => 'Création Slogan', 'token' => 20, 'price' => $randomPrice, 'token_name' => 'slogan_tokens'],

            // PREMIUM
            ['code' => 'CREATION-LOGO', 'name' => 'Création Logo', 'token' => 15, 'token_name' => 'logo_generation_tokens'],
            ['code' => 'CREATION-COMPANY-NAME', 'name' => 'Création Company Name', 'token' => 15, 'token_name' => 'company_name_tokens'],
            ['code' => 'CREATION-VALUES', 'name' => 'Création Value', 'token' => 15, 'token_name' => 'values_tokens'],
            ['code' => 'CREATION-TON-VOICE', 'name' => 'Création Ton Voice', 'token' => 15, 'token_name' => 'ton_voice_tokens'],
            ['code' => 'CREATION-TYPOGRAPHIE', 'name' => 'Création Typographie', 'token' => 15, 'token_name' => 'typography_tokens'],
            ['code' => 'CREATION-SLOGAN', 'name' => 'Création Slogan', 'token' => 15, 'price' => $randomPrice, 'token_name' => 'slogan_tokens'],

            // FREE
            ['code' => 'CREATION-LOGO-FREE', 'name' => 'Création Logo', 'token' => 10, 'price' => 0, 'token_name' => 'logo_generation_tokens'],
            ['code' => 'CREATION-COMPANY-NAME-FREE', 'name' => 'Création Company Name', 'token' => 10, 'price' => 0, 'token_name' => 'company_name_tokens'],
            ['code' => 'CREATION-VALUES-FREE', 'name' => 'Création Value', 'token' => 10, 'price' => 0, 'token_name' => 'values_tokens'],
            ['code' => 'CREATION-TON-VOICE-FREE', 'name' => 'Création Ton Voice', 'token' => 10, 'price' => 0, 'token_name' => 'ton_voice_tokens'],
            ['code' => 'CREATION-TYPOGRAPHIE-FREE', 'name' => 'Création Typographie', 'token' => 10, 'price' => 0, 'token_name' => 'typography_tokens'],
            ['code' => 'CREATION-SLOGAN-FREE', 'name' => 'Création Slogan', 'token' => 10, 'price' => $randomPrice, 'token_name' => 'slogan_tokens'],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $data) {
            $service = (new Service())
                ->setName($data['name'])
                ->setPrice(array_key_exists('price', $data) ? $data['price'] : $this->getPrice())
                ->setToken($data['token'])
                ->setServiceCode($data['token_name'])
                ->setCreatedAt($this->getDateTimeImmutable());
            $manager->persist($service);
            $this->addReference('service_'.$data['code'], $service);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    use FakerTrait;

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@domain.com')
            ->setUsername('main.user')
            ->setPassword($this->passwordHasher->hashPassword(
                $user,
                'Admin@123'
            ))
            ->setPhone($this->getFaker()->phoneNumber())
            ->setFullName('Main User')
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setIsVerified(true);
        $manager->persist($user);

        $userAdmin = new User();
        $userAdmin->setEmail('admin@domain.com')
            ->setUsername('admin.user')
            ->setPassword($this->passwordHasher->hashPassword(
                $userAdmin,
                'Admin@123'
            ))
            ->setPhone($this->getFaker()->phoneNumber())
            ->setFullName('Admin User')
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setIsVerified(true);
        $manager->persist($userAdmin);

        for ($i = 1; $i <= 10; ++$i) {
            $userClient = (new User())
                ->setEmail($this->getFaker()->unique()->email())
                ->setUsername($this->getFaker()->unique()->userName())
                ->setFullName($this->getFaker()->lastName().' '.$this->getFaker()->firstName())
                ->setPhone($this->getFaker()->phoneNumber())
                ->setRoles(['ROLE_CLIENT', 'ROLE_USER'])
                ->setIsVerified(true)
                ->setCreatedAt($this->getDateTimeImmutable())
            ;
            $userClient->setPassword($this->passwordHasher->hashPassword(
                $userClient,
                'Admin@123'
            ));
            $manager->persist($userClient);
            $this->addReference("client.user.$i", $userClient);
        }

        $manager->flush();
    }
}

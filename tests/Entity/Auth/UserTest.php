<?php

namespace App\Tests\Entity\Auth;

use App\Entity\Auth\User;
use App\Tests\Trait\ValidationTestTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Test\ResetDatabase;

class UserTest extends KernelTestCase
{
    use ResetDatabase;
    use ValidationTestTrait;

    public function getEntity(): User
    {
        return (new User())
            ->setEmail('admin@domain.com')
            ->setUsername('admin.user')
            ->setPassword('Admin@123')
            ->setRoles(['ROLE_USER'])
            ->setPhone('0123456789')
            ->setCreatedAt(new \DateTimeImmutable('now'))
            ->setIsVerified(true)
        ;
    }

    public function persistUser(User $user): void
    {
        self::bootKernel();
        /** @var EntityManagerInterface $manager */
        $manager = static::getContainer()->get(EntityManagerInterface::class);
        /** @var UserPasswordHasherInterface $passwordHasher */
        $passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);
        $user->setPassword(
            $passwordHasher->hashPassword($user, (string) $user->getPassword())
        );
        $manager->persist($user);
        $manager->flush();
    }

    public function testValidEntity(): void
    {
        $this->assertHasErrors($this->getEntity());
    }

    public function testUniqueUserEmail(): void
    {
        $user = $this->getEntity();
        $this->persistUser($user);
        $newUesr = $this->getEntity()->setEmail('user.new@domain.com');
        $this->persistUser($newUesr);
        $this->assertHasErrors($newUesr, 1);
    }

    public function testInvalidUniqueUserEmail(): void
    {
        $this->persistUser($this->getEntity());
        $this->assertHasErrors($this->getEntity(), 1);
    }
}

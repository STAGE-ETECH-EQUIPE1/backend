<?php

namespace App\Services\Auth;

use App\DTO\Request\UpdatePasswordDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        private readonly ResetPasswordHelperInterface $resetPasswordHelper,
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly MailerInterface $mailer,
        #[Autowire('%app.frontend_url%')]
        private readonly string $frontendUrl,
    ) {
    }

    public function sendResetPasswordEmail(string $email): void
    {
        $user = $this->userRepository->getByEmail($email);

        if ($user) {
            try {
                $resetToken = $this->resetPasswordHelper->generateResetToken($user);
            } catch (ResetPasswordExceptionInterface $e) {
                throw new \Exception('Email could not be sent. Please try again later.');
            }
            $email = (new TemplatedEmail())
                ->from(new Address('no-reply@domain.com', 'ORBIXUP Mail Bot'))
                ->to((string) $user->getEmail())
                ->subject('Your password reset request')
                ->htmlTemplate('email/reset_password.html.twig')
                ->context([
                    'resetToken' => $resetToken,
                    'frontendUrl' => $this->frontendUrl,
                ])
            ;
            $this->mailer->send($email);
        }
    }

    public function updateUserPassword(string $token, UpdatePasswordDTO $updatePasswordDTO): void
    {
        /** @var User $user */
        $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        $plainPassword = $updatePasswordDTO->getNewPassword();
        $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));
        $this->entityManager->flush();
    }
}

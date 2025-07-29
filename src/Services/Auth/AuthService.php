<?php

namespace App\Services\Auth;

use App\DTO\Request\UpdatePasswordDTO;
use App\Entity\Auth\User;
use App\Security\EmailVerifier;
use App\Services\User\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

final readonly class AuthService implements AuthServiceInterface
{
    public function __construct(
        private ResetPasswordHelperInterface $resetPasswordHelper,
        private UserServiceInterface $userService,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private MailerInterface $mailer,
        private EmailVerifier $emailVerifier,
        #[Autowire('%app.frontend_url%')]
        private string $frontendUrl,
    ) {
    }

    public function sendVerificationEmail(string $email): void
    {
        $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $this->userService->getByEmail($email),
            (new TemplatedEmail())
                ->from(new Address('noreply@gmail.com', 'ORBIXUP Mail Bot'))
                ->to($email)
                ->subject('Please Confirm your Email')
                ->htmlTemplate('email/verification_email.html.twig')
        );
    }

    public function sendResetPasswordEmail(string $email): void
    {
        $user = $this->userService->getByEmail($email);
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

    public function updateUserPassword(string $token, UpdatePasswordDTO $updatePasswordDTO): void
    {
        /** @var User $user */
        $user = $this->resetPasswordHelper->validateTokenAndFetchUser($token);
        $plainPassword = $updatePasswordDTO->getNewPassword();
        $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));
        $this->entityManager->flush();
    }
}

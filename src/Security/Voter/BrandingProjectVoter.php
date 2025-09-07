<?php

namespace App\Security\Voter;

use App\Entity\Auth\Client;
use App\Entity\Auth\User;
use App\Entity\Branding\BrandingProject;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * @extends Voter<string, ?BrandingProject>
 */
final class BrandingProjectVoter extends Voter
{
    public const EDIT = 'BRANDING_PROJECT_EDIT';
    public const CREATE = 'BRANDING_PROJECT_CREATE';
    public const VIEW = 'BRANDING_PROJECT_VIEW';
    public const SUBMIT = 'BRANDING_PROJECT_SUBMIT';
    public const LIST_ALL = 'ARTICLE_ALL';

    public function __construct(
        private readonly Security $security,
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::LIST_ALL, self::CREATE])
         || in_array($attribute, [self::EDIT, self::VIEW, self::SUBMIT])
            && $subject instanceof BrandingProject;
    }

    protected function voteOnAttribute(
        string $attribute,
        mixed $subject,
        TokenInterface $token,
    ): bool {
        $user = $token->getUser();
        if (!($subject instanceof BrandingProject)) {
            return false;
        }
        $client = $subject->getClient();
        if (
            (!$user instanceof User)
            || (!$client instanceof Client)
        ) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
            case self::VIEW:
            case self::SUBMIT:
                return $client->getId() === $user->getId();
            case self::LIST_ALL:
                return $this->security->isGranted('ROLE_ADMIN');
            case self::CREATE:
                return $this->security->isGranted('ROLE_CLIENT');
        }

        return false;
    }
}

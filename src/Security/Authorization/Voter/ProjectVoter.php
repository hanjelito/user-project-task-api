<?php

declare(strict_types=1);

namespace App\Security\Authorization\Voter;

use App\Entity\Project;
use App\Entity\User;
use App\Security\Role;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ProjectVoter extends BaseVoter
{
    private const PROJECT_READ    = 'PROJECT_READ';
    private const PROJECT_CREATE  = 'PROJECT_CREATE';
    private const PROJECT_UPDATE  = 'PROJECT_UPDATE';
    private const PROJECT_DELETE  = 'PROJECT_DELETE';

    protected function supports(string $attribute, $subject): bool
    {
        return \in_array($attribute, $this->getSupportedAttributes(), true);
    }
    /**
     * @param Project|null $subject
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $tokenUser */
        $tokenUser =$token->getUser();
        if (self::PROJECT_READ === $attribute) {
            if (null === $subject) {
                return $this->security->isGranted(Role::ROLE_ADMIN);
            }

            return $this->security->isGranted(Role::ROLE_ADMIN)
                || $this->projectRepository->userIsMember($subject, $tokenUser);

        }

        if (self::PROJECT_CREATE === $attribute) {
            return true;
        }

        if(self::PROJECT_UPDATE === $attribute) {
            return $this->security->isGranted(Role::ROLE_ADMIN)
                || $this->projectRepository->userIsMember($subject, $tokenUser);
        }

        if (self::PROJECT_DELETE === $attribute) {
            return $this->security->isGranted((Role::ROLE_ADMIN))
                || $subject->isOwnedBy($tokenUser);
        }

        return false;

    }

    private function getSupportedAttributes(): array
    {
        return [
            self::PROJECT_READ,
            self::PROJECT_CREATE,
            self::PROJECT_UPDATE,
            self::PROJECT_DELETE,
        ];
    }
}
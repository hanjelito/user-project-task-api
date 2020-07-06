<?php

declare(strict_types=1);

namespace App\Security\Authorization\Voter;


use App\Entity\Task;
use App\Entity\User;
use App\Security\Role;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TaskVoter extends BaseVoter
{
    private const TASK_READ     = 'TASK_READ';
    private const TASK_CREATE   = 'TASK_CREATE';
    private const TASK_UPDATE   = 'TASK_UPDATE';
    private const TASK_DELETE   = 'TASK_DELETE';

    protected function supports(string $attribute, $subject): bool
    {
        return \in_array($attribute, $this->getSupportedAttributes(), true);
    }

    /**
     * @param Task|null Subjet
    */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $tokenUser */
        $tokenUser = $token->getUser();

        if (self::TASK_READ === $attribute) {
            if (null === $subject) {
                return $this->security->isGranted(Role::ROLE_ADMIN);
            }

            if (null !== $subject->getGroup()) {
                return $this->security->isGranted(Role::ROLE_ADMIN)
                    || $this->projectRepository->userIsMember($subject->getProject(), $tokenUser);
            }

            return $this->security->isGranted(Role::ROLE_ADMIN)
                || $subject->isOwnedBy($tokenUser);
        }

        if (self::TASK_CREATE === $attribute) {
            return true;
        }

        if (\in_array($attribute, [self::TASK_UPDATE, self::TASK_DELETE])) {
            if (null !== $subject->getGroup()) {
                return $this->security->isGranted(Role::ROLE_ADMIN)
                    || $this->projectRepository->userIsMember($subject->getProject(), $tokenUser);
            }

            return $this->security->isGranted(Role::ROLE_ADMIN)
                || $subject->isOwnedBy($tokenUser);
        }

        return false;
    }

    private function getSupportedAttributes(): array
    {
        return [
          self::TASK_READ,
          self::TASK_CREATE,
          self::TASK_UPDATE,
          self::TASK_DELETE,
        ];
    }
}
<?php

declare(strict_types=1);

namespace App\Security\Authorization\Voter;

use App\Repository\ProjectRepository;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

abstract class BaseVoter extends Voter
{
    protected Security $security;

    protected ProjectRepository $projectRepository;

    public function __construct(Security $security, ProjectRepository $projectRepository)
    {
        $this->security = $security;
    }
}

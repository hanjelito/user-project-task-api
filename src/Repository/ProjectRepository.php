<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Project;
use App\Entity\User;

class ProjectRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return Project::class;
    }

    public function findOneById(string $id): ?Project
    {
        /** @var Project $project */
        $project = $this->objectRepository->find($id);

        return $project;
    }

    public function userIsMember(Project $project, User $user): bool
    {
        foreach ($project->getUsers() as $userProject) {
            if ($userProject->getId() === $user->getId()) {
                return true;
            }
        }

        return false;
    }

    public function save(Project $project): void
    {
        $this->saveEntity($project);
    }
}

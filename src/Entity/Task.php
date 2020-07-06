<?php

declare(strict_types=1);

namespace App\Entity;


use Ramsey\Uuid\Uuid;


class Task
{
    private string $id;

    private string $name;

    private ?string $description = null;

    private ?User $user;

    private ?Project $project;

    private ?\DateTime $createdAt = null;

    private ?\DateTime $updatedAt = null;


    /**
     * @throws \Exception
     */

    public function __construct(string $name, string $description,  User $user,  Project $project = null, string $id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
        $this->name = $name;
        $this->description = $description;
        $this->user = $user;
        $this->project = $project;
        $this->createdAt = new \DateTime();
        $this->markAsUpdated();
    }
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->name;
    }

    public function setDescription(string $name): void
    {
        $this->name = $name;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function markAsUpdated(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function isOwnedBy(User $user): bool
    {
        if (null !== $this->getUser()) {
            return $this->getUser()->getId() === $user->getId();
        }

        return false;
    }

    public function isOwnedByGroup(Project $project): bool
    {
        if (null !== $this->getProject()) {
            return $this->getProject()->getId() === $project->getId();
        }

        return false;
    }

}
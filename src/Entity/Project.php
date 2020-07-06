<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;

class Project
{
    private ?string $id;

    private string $name;

    private User $owner;

    private ?string $description = null;

    private ?\DateTime $createdAt = null;

    private ?\DateTime $updatedAt = null;

    /** @var Collection|User[] */
    private Collection $users;

    /** @var Collection|Task[] */
    private ?Collection $tasks = null;

    /**
     * @throws \Exception
     */
    public function __construct(string $name, User $owner, string $description = null, string $id = null)
    {
        $this->id = $id ?? Uuid::uuid4()->toString();
        $this->name = $name;
        $this->owner = $owner;
        $this->description = $description;
        $this->createdAt = new \Datetime();
        $this->users = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->markAsUpdated();
    }

    public function getId(): ?string
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

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function markAsUpdated(): void
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function getUser(User $user): void
    {
        $this->users->add($user);

        $user->addProject($this);
    }

    public function addUser(User $user): void
    {
        $this->users->add($user);

        $user->addProject($this);
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->getOwner()->getId() === $user->getId();
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }
}

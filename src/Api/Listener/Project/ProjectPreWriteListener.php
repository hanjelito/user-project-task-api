<?php

declare(strict_types=1);

namespace App\Api\Listener\Project;


use App\Api\Listener\PreWriteListener;
use App\Entity\Project;
use App\Entity\User;
use App\Exception\Project\CannotAddAnotherOwnerException;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class ProjectPreWriteListener implements  PreWriteListener
{
    private const POST_PROJECT = 'api_projects_post_collection';
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelView(ViewEvent $event): void
    {
        /** @var User $tokenUser */
        $tokenUser = $this->tokenStorage->getToken()->getUser();

        $request = $event->getRequest();

        if (self::POST_PROJECT === $request->get('_route')) {
            /** @var Project $project */
            $project = $event->getControllerResult();

            if (!$project->isOwnedBy($tokenUser)) {
                throw CannotAddAnotherOwnerException::create();
            }

            $project->adduser($tokenUser);
        }
    }
}
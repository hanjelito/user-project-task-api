<?php


namespace App\Exception\Project;


use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

class CannotAddAnotherOwnerException extends AccessDeniedException
{
    private  const MESSAGE = 'You cannot add another user as owner';


    public static function create(): self
    {
        throw new self(self::MESSAGE);
    }
}
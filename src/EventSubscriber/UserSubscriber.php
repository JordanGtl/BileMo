<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * CurrentUserSubscriber constructor.
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [['setCurrentClient', EventPriorities::PRE_WRITE]],
        ];
    }

    public function setCurrentClient(GetResponseForControllerResultEvent $event)
    {
        $object = $event->getControllerResult();

        if (method_exists($object, 'setClient'))
        {
            $object->setClient($this->tokenStorage->getToken()->getUser());
            $event->setControllerResult($object);
        }
    }
}
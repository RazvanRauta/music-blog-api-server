<?php

/**
 * @author Razvan Rauta
 * 21.05.2019
 * 21:40
 */

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Song;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class PublishedDateEntitySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setDatePublished', EventPriorities::PRE_WRITE]
        ];
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     * @throws \Exception
     */
    public function setDatePublished(GetResponseForControllerResultEvent $event)
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$entity instanceof Song || Request::METHOD_POST !== $method) {
            return;
        }

        $entity->setPublished(new DateTime("now"));
    }
}

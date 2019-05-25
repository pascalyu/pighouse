<?php

namespace App\MyBundle\Listener;

use Doctrine\ORM\Event\PreFlushEventArgs;

class DoctrineListener {

    public function preFlush(PreFlushEventArgs $event) {
        $em = $event->getEntityManager();
        foreach ($em->getUnitOfWork()->getScheduledEntityDeletions() as $object) {
            if (method_exists($object, "getDeletedAt")) {
                if ($object->getDeletedAt() instanceof \Datetime) {
                    continue;
                } else {
                    $object->setDeletedAt(new \DateTime());
                    $em->merge($object);
                    $em->persist($object);
                }
            }
        }
    }

}

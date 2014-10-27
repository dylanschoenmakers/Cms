<?php

namespace Opifer\EavBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;

use Opifer\EavBundle\Eav\ValueInterface;
use Opifer\EavBundle\Entity\ValueSet;
use Opifer\EavBundle\Manager\EavManager;

/**
 * Empty Value Listener
 *
 * Adds/removes empty values to/from the valueset, to avoid storing null values
 * inside the database
 */
class EmptyValueListener
{
    /** @var EavManager */
    protected $eavManager;

    /**
     * Constructor
     *
     * @param ValueManager $eavManager
     */
    public function __construct(EavManager $eavManager)
    {
        $this->eavManager = $eavManager;
    }

    /**
     * Create empty values for non-persisted values
     *
     * @param LifeCycleEventArgs $args
     *
     * @return void
     */
    public function postLoad(LifeCycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof ValueSet && $entity->getValues() !== null) {
            $this->eavManager->replaceEmptyValues($entity);
        }
    }

    /**
     * Remove empty values after persisting, to avoid null 'Value' values in
     * the database.
     *
     * @param LifeCycleEventArgs $args
     *
     * @return void
     */
    public function postPersist(LifeCycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof ValueInterface && $entity->isEmpty()) {
            $entityManager->remove($entity);
        }
    }
}

<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\GroupeTags;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;


class GroupeTagDataPersist implements ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this-> entityManager = $entityManager;
    }


    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof GroupeTags;
    }

    /**
     * @param GroupeTags $data
     * @return GroupeTags
     */
    public function persist($data, array $context = [])
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setArchived(true);
        $this->entityManager->persist($data);
        foreach($data->getUsers() as $User) {
            $User->setArchived(true);
        }
        $this->entityManager->flush();
    }
}
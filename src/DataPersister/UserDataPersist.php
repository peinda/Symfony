<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;


class UserDataPersist implements ContextAwareDataPersisterInterface
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
        return $data instanceof User;
    }

     
    public function persist($data, array $context = [])
    {
    }

    public function remove($data, array $context = [])
    {
        $data->setArchived(true);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}
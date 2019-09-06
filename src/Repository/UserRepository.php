<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;

class UserRepository
{

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
    }

    public function save(User $user): bool
    {
        try {
            $this->em->persist($user);
            $this->em->flush();

            return true;
        } catch (Exception $e) {
            //TODO:log error

            return false;
        }
    }

    public function removeUserByUsername(string $username): bool
    {
        try {
            $user = $this->repository->findOneByUsername($username);
            $this->em->remove($user);
            $this->em->flush();

            return true;
        } catch (Exception $e) {
            //TODO:log error

            return false;
        }
    }

    public function findOneByUsername(string $username): ?User
    {
        return $this->repository->findOneByUsername($username);
    }
}
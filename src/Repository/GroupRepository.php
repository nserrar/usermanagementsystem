<?php

namespace App\Repository;

use App\Entity\Group;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;

class GroupRepository
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
        $this->repository = $entityManager->getRepository(Group::class);
    }

    /**
     * @param Group $group
     * @return bool
     */
    public function save(Group $group): bool
    {
        try {
            $this->em->persist($group);
            $this->em->flush();

            return true;
        } catch (Exception $e) {
            //TODO:log error

            return false;
        }
    }

    /**
     * @param string $groupName
     * @return bool
     */
    public function removeGroupByName(string $groupName): bool
    {
        try {
            $group = $this->repository->findOneByGroupName($groupName);
            $this->em->remove($group);
            $this->em->flush();

            return true;
        } catch (Exception $e) {
            //TODO:log error

            return false;
        }
    }

    /**
     * @param string $username
     * @param string $groupName
     * @return bool
     */
    public function addUserToGroup(string $username, string $groupName): bool
    {
        try {
            /** @var Group $group */
            $group = $this->repository->findOneByGroupName($groupName);
            /** @var User $user */
            $user = $this->em->getRepository(User::class)->findOneByUsername($username);

            $group->addUser($user);
            $this->em->persist($group);
            $this->em->flush();

            return true;
        } catch (Exception $e) {
            //TODO:log error

            return false;
        }
    }

    /**
     * @param string $username
     * @param string $groupName
     * @return bool
     */
    public function removeUserFromGroup(string $username, string $groupName): bool
    {
        try {
            /** @var Group $group */
            $group = $this->repository->findOneByGroupName($groupName);
            /** @var User $user */
            $user = $this->em->getRepository(User::class)->findOneByUsername($username);

            $group->removeUser($user);
            $this->em->persist($group);
            $this->em->flush();

            return true;
        } catch (Exception $e) {
            //TODO:log error

            return false;
        }
    }

}
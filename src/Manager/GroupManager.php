<?php

namespace App\Manager;

use App\Entity\Group;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class GroupManager
{

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(GroupRepository $groupRepository, UserRepository $userRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $name
     * @param bool   $isAuthorized
     * @return bool
     */
    public function createGroup(string $name, bool $isAuthorized = false): bool
    {
        if (!$isAuthorized) {
            throw new AccessDeniedHttpException('Not allowed.');
        }

        $group = new Group();
        $group->setGroupName($name);

        return $this->groupRepository->save($group);
    }

    /**
     * @param string $name
     * @param bool   $isAuthorized
     * @return bool
     */
    public function removeGroup(string $name, bool $isAuthorized = false): bool
    {
        if (!$isAuthorized) {
            throw new AccessDeniedHttpException('Not allowed.');
        }

        return $this->groupRepository->removeGroupByName($name);
    }

    /**
     * @param string $username
     * @param string $groupName
     * @param bool   $isAuthorized
     * @return bool
     */
    public function addUserToGroup(string $username, string $groupName, bool $isAuthorized = false): bool
    {
        if (!$isAuthorized) {
            throw new AccessDeniedHttpException('Not allowed.');
        }

        return $this->groupRepository->addUserToGroup($username, $groupName);
    }

    /**
     * @param string $username
     * @param string $groupName
     * @param bool   $isAuthorized
     * @return bool
     */
    public function removeUserFromGroup(string $username, string $groupName, bool $isAuthorized = false): bool
    {
        if (!$isAuthorized) {
            throw new AccessDeniedHttpException('Not allowed.');
        }

        return $this->groupRepository->removeUserFromGroup($username, $groupName);
    }

}
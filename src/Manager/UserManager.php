<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserManager
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    //TODO: implement JWT
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $email
     * @param string $name
     * @param string $password
     * @param string $username
     * @param bool   $isAuthorized
     * @return bool
     */
    public function createUser(
        string $email,
        string $name,
        string $password,
        string $username,
        bool $isAuthorized = false
    ): bool {
        if (!$isAuthorized) {
            throw new AccessDeniedHttpException('Not allowed.');
        }

        $user = new User();
        $user->setEmail($email);
        $user->setName($name);
        $user->setPassword($password);
        $user->setUsername($username);

        return $this->userRepository->save($user);
    }

    /**
     * @param string $username
     * @param bool   $isAuthorized
     * @return bool
     */
    public function removeUser(string $username, bool $isAuthorized = false): bool
    {
        if (!$isAuthorized) {
            throw new AccessDeniedHttpException('Not allowed.');
        }

        return $this->userRepository->removeUserByUsername($username);
    }
}
<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;

class AuthManager
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Verify if the user is admin
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function checkAuthorization(string $username, string $password): bool
    {
        /** @var User $user */
        $user = $this->userRepository->findOneByUsername($username);

        return (null !== $user && $user->getPassword() === $password && $user->getIsAdmin());
    }
}
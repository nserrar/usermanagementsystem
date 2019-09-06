<?php

namespace App\Controller\Rest;

use App\Manager\AuthManager;
use App\Manager\UserManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController
{

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var AuthManager
     */
    private $authManager;

    public function __construct(UserManager $userManager, AuthManager $authManager)
    {
        $this->userManager = $userManager;
        $this->authManager = $authManager;
    }

    /**
     * Creates User (params : adminuser, adminpassword, username, password, name, email)
     *
     * @Rest\Post("/user/create")
     * @param Request $request
     * @return View
     */
    public function createUser(Request $request): View
    {
        $this->authManager->checkAuthorization($request->get('adminuser'), $request->get('adminpassword'));
        $data = $request->request->all();
        $user = $this->userManager->createUser($data['email'], $data['name'], $data['password'], $data['username']);

        return View::create($user, Response::HTTP_CREATED);
    }

    /**
     * Removes User (params : adminuser, adminpassword, username)
     *
     * @Rest\Post("/user/delete")
     * @param string $username
     * @return View
     */
    public function deleteArticle(Request $request): View
    {
        $this->authManager->checkAuthorization($request->get('adminuser'), $request->get('adminpassword'));
        $this->userManager->removeUser($request->get('username'));

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
<?php

namespace App\Controller\Rest;

use App\Manager\AuthManager;
use App\Manager\GroupManager;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GroupController
{

    /**
     * @var GroupManager
     */
    private $groupManager;

    /**
     * @var AuthManager
     */
    private $authManager;

    public function __construct(GroupManager $groupManager, AuthManager $authManager)
    {
        $this->groupManager = $groupManager;
        $this->authManager = $authManager;
    }

    /**
     * Creates Group (params : 'groupname')
     *
     * @Rest\Post("/group/create")
     * @param Request $request
     * @return View
     */
    public function createGroup(Request $request): View
    {
        $this->authManager->checkAuthorization($request->get('adminuser'), $request->get('adminpassword'));
        $group = $this->groupManager->createGroup($request->get('name'));

        return View::create($group, Response::HTTP_CREATED);
    }

    /**
     * Removes Group (params : adminuser, adminpassword, groupname)
     *
     * @Rest\Post("/group/delete")
     * @param Request $request
     * @return View
     */
    public function deleteGroup(Request $request): View
    {
        $this->authManager->checkAuthorization($request->get('adminuser'), $request->get('adminpassword'));
        $this->groupManager->removeGroup($request->get('groupname'));

        return View::create([], Response::HTTP_NO_CONTENT);
    }

    /**
     * add user to Group (params: adminuser, adminpassword, username, groupname)
     *
     * @Rest\Post("/group/add-user")
     * @param Request $request
     * @return View
     */
    public function addUserToGroup(Request $request): View
    {
        $this->authManager->checkAuthorization($request->get('adminuser'), $request->get('adminpassword'));
        $group = $this->groupManager->addUserToGroup($request->get('username'), $request->get('groupname'));

        return View::create($group, Response::HTTP_CREATED);
    }

    /**
     * add user to Group (params: adminuser, adminpassword, username, groupName)
     *
     * @Rest\Post("/group/remove-user")
     * @param Request $request
     * @return View
     */
    public function removeUserFromGroup(Request $request): View
    {
        $this->authManager->checkAuthorization($request->get('adminuser'), $request->get('adminpassword'));
        $group = $this->groupManager->removeUserFromGroup($request->get('username'), $request->get('groupname'));

        return View::create($group, Response::HTTP_CREATED);
    }
}
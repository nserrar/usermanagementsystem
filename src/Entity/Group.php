<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Group
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="groups")
 */
class Group
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=150, unique=true)
     */
    protected $groupName;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="User", inversedBy="groups")
     * @ORM\JoinTable(name="user_group",
     *      joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    protected $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param mixed $groupName
     * @return Group
     */
    public function setGroupName($groupName): Group
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * @param User $user
     * @return Group
     */
    public function addUser(User $user): Group
    {
        $this->users->add($user);

        return $this;
    }

    /**
     * @param User $user
     * @return Group
     */
    public function removeUser(User $user): Group
    {
        $this->users->removeElement($user);

        return $this;
    }
}
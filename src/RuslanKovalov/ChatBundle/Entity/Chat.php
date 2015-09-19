<?php

namespace RuslanKovalov\ChatBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Chat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RuslanKovalov\ChatBundle\Entity\Repository\ChatRepository")
 */
class Chat implements \JsonSerializable
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="chats")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="chat")
     */
    private $messages;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Chat
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Add user
     *
     * @param User $user
     *
     * @return Chat
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add message
     *
     * @param Message $message
     *
     * @return Chat
     */
    public function addMessage(Message $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param Message $message
     */
    public function removeMessage(Message $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Specify data which should be serialized to JSON
     */
    function jsonSerialize()
    {
        $userIds =$this->getUsers()
            ->map(
                function(User $entity)
                {
                    $interestIds[] = $entity->getId();
                    return $interestIds;
                }
            )
            ->getValues();

        $messageIds =$this->getMessages()
            ->map(
                function(Message $entity)
                {
                    $interestIds[] = $entity->getId();
                    return $interestIds;
                }
            )
            ->getValues();


        return [
            'id' => $this->getId(),
            'userIds' => $userIds,
            'messageIds' => $messageIds,
            'created' => $this->getCreated(),
        ];
    }
}

<?php

namespace RuslanKovalov\ChatBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RuslanKovalov\ChatBundle\Entity\Repository\UserRepository")
 */
class User
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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\ManyToMany(targetEntity="Chat", inversedBy="users")
     */
    private $chats;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="sender")
     */
    private $messages;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->chats = new ArrayCollection();
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Add chat
     *
     * @param Chat $chat
     *
     * @return User
     */
    public function addChat(Chat $chat)
    {
        $this->chats[] = $chat;

        return $this;
    }

    /**
     * Remove chat
     *
     * @param Chat $chat
     */
    public function removeChat(Chat $chat)
    {
        $this->chats->removeElement($chat);
    }

    /**
     * Get chats
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChats()
    {
        return $this->chats;
    }

    /**
     * Add message
     *
     * @param Message $message
     *
     * @return User
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
        $chatIds = $this->getChats()
            ->map(
                function(Chat $entity)
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
            'username' => $this->getUsername(),
            'chatIds' => $chatIds,
            'messageIds' => $messageIds,
        ];
    }
}

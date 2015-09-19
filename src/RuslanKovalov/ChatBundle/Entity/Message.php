<?php

namespace RuslanKovalov\ChatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RuslanKovalov\ChatBundle\Entity\Repository\MessageRepository")
 */
class Message implements \JsonSerializable
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messages", cascade={"persist"})
     */
    private $sender;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Chat", inversedBy="messages", cascade={"persist"})
     */
    private $chat;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $status;


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
     * @return Message
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
     * Set status
     *
     * @param string $status
     *
     * @return Message
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set sender
     *
     * @param User $sender
     *
     * @return Message
     */
    public function setSender(User $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set chat
     *
     * @param Chat $chat
     *
     * @return Message
     */
    public function setChat(Chat $chat = null)
    {
        $this->chat = $chat;

        return $this;
    }

    /**
     * Get chat
     *
     * @return Chat
     */
    public function getChat()
    {
        return $this->chat;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Chat
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Specify data which should be serialized to JSON
     */
    function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'sender' => $this->getSender()->getId(),
            'chat' => $this->getChat()->getId(),
            'text' => $this->getText(),
            'created' => $this->getCreated(),
            'status' => $this->getStatus(),
        ];
    }
}

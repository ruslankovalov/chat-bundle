<?php

namespace RuslanKovalov\ChatBundle\Controller;

use Mcfedr\JsonFormBundle\Controller\JsonController;
use RuslanKovalov\ChatBundle\Entity\Chat;
use RuslanKovalov\ChatBundle\Entity\Message;
use RuslanKovalov\ChatBundle\Form\ChatType;
use RuslanKovalov\ChatBundle\Form\MessageType;
use RuslanKovalov\ChatBundle\Form\StatusType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ChatController extends JsonController
{
    /**
     * @Route("/api/chat")
     * @Method({"POST"})
     * @param Request $request
     * @return array
     */
    public function createChat(Request $request)
    {
        $chat = new Chat();
        $form = $this->createForm(new ChatType());
        $this->handleJsonForm($form, $request);

        $em = $this->getDoctrine()->getManager();
        $em->persist($chat);
        $em->flush();

        return new JsonResponse(['chat' => $chat]);
    }

    /**
     * @Route("/api/message/new")
     * @Method({"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function postNewMessage(Request $request)
    {
        $message = new Message();
        $form = $this->createForm(new MessageType(), $message);
        $this->handleJsonForm($form, $request);

        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        return new JsonResponse(['message' => $message]);
    }

    /**
     * @Route("/api/message/{id}/update, requirements={"id" = "\d+"})
     * @Method({"PUT"})
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateMessageStatus(Request $request, $id)
    {
        $message = $this->getDoctrine()->getRepository("RuslanKovalovChatBundle:Message")->find($id);
        $form = $this->createForm(new StatusType(), $message);
        $this->handleJsonForm($form, $request);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new JsonResponse(['message' => $message]);
    }
}
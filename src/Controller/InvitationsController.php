<?php

namespace App\Controller;

use App\Entity\Invitations;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\Helpers\Constants;


class InvitationsController extends AbstractController
{
    private $em;
    private $userRepository;
    public function __construct(EntityManagerInterface $em, UserRepository $userRepository, ) 
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
    }

    /**
     * Search the User database
     *
     * @return Response
     */
    #[Route('/search', name: 'app_search')]
    public function searchFriends(Request $request): Response
    {
        $users = $this->userRepository->findOneLikeEmail($request->request->get('query'));
        foreach ($users as $user){
            $user->new_email = $user->getEmail();
        }
    
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json'); 
        return $response->setContent(json_encode([
            'data' => $users,
        ]));
        exit;
    }

    /**
     * Accept an invite
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    #[Route('/invite', name: 'app_invite')]
    public function submitInvite(EntityManagerInterface $em, Request $request): Response
    {
        $invitations = new Invitations();
        $invitations->setMessage($request->request->get('message'));
        $invitations->setSenderId($this->getUser());
        $receiver = $this->userRepository->findByEmail($request->request->get('send_to'));
        $invitations->setReceiverId($receiver[0]);
        $invitations->setSubject($request->request->get('subject'));
        $invitations->setAcceptance(Constants::DEFAULT_STATUS);
        $invitations->setStatus(Constants::DEFAULT_STATUS);

        $this->em->persist($invitations);
        $em->flush();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $response->setContent(json_encode([
            'data' => 'Your message has been successfully saved',
        ]));
    }
}

<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\InvitationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Helpers\Constants;

class HomeController extends AbstractController
{
    private $em;
    private $invitationRepository;
    public function __construct(EntityManagerInterface $em, InvitationsRepository $invitationRepository) 
    {
        $this->em = $em;
        $this->invitationRepository = $invitationRepository;
    }

    /**
     * Returning the index page
     *
     * @return Response
     */
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * Get all invitations for the currently logged in user
     *
     * @return Response
     */
    #[Route('/get-invitations', name: 'app_get_invitations')]
    public function getInvitations(): Response
    {
        $allInvitations = $this->invitationRepository->getUnreadInvitations($this->getUser()->getId(), Constants::NO_RESPONSE);
        foreach ($allInvitations as $invitation){
            $invitation->new_id = $invitation->getId();
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json'); 
        return $response->setContent(json_encode([
            'data' => $allInvitations,
            'count' => count($allInvitations)
        ]));
    }

    /**
     * Accept an invite
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/accept', name: 'app_accept_invite')]
    public function Accept(Request $request): Response
    {
        $invitation = $this->invitationRepository->find($request->request->get('id'));
        $invitation->setAcceptance(Constants::ACCEPTED);
        $this->em->flush();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $response->setContent(json_encode([
            'data' => 'Your attendance has been Accepted',
        ]));      
    }

    /**
     * Decline an invite
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/decline', name: 'app_accept_decline')]
    public function Decline(Request $request): Response
    {
        $invitation = $this->invitationRepository->find($request->request->get('id'));
        $invitation->setAcceptance(Constants::DECLINED);
        $this->em->flush();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        return $response->setContent(json_encode([
            'data' => 'Your attendance has been Declined',
        ]));      
    }
}

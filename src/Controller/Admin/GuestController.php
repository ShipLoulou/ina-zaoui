<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\Query\Expr\Func;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class GuestController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $encoder
    ) {}

    #[Route('/admin/guest', name: 'admin_guest_index')]
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);

        $criteria = ['admin' => false];

        $guests = $this->userRepository->findBy(
            $criteria,
            ['id' => 'ASC'],
            25,
            25 * ($page - 1)
        );

        $total = $this->userRepository->count($criteria);

        return $this->render('admin/guest/index.html.twig', [
            'guests' => $guests,
            'total' => $total,
            'page' => $page
        ]);
    }

    #[Route('/admin/guest/add', name: 'admin_guest_add')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User */
            $user = $form->getData();

            $password = $form->getData()->getPassword();
            $hash = $this->encoder->hashPassword($user, $password);

            $user->setPassword($hash);

            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('admin_guest_index');
        }

        return $this->render('admin/guest/add.html.twig', ['form' => $form->createView()]);
    }

    #[Route('admin/guest/update/status/{id}', name: 'admin_guest_update_status')]
    public function updateStatus(int $id): Response
    {
        /** @var User */
        $user = $this->userRepository->find($id);

        if ($user->isStatus()) {
            $user->setStatus(false);
        } else {
            $user->setStatus(true);
        }

        $this->em->flush();

        return $this->redirectToRoute('admin_guest_index');
    }

    #[Route('admin/guest/delete/{id}', name: 'admin_guest_delete')]
    public function delete($id): Response
    {
        /** @var User */
        $user = $this->userRepository->find($id);

        $this->em->remove($user);
        $this->em->flush();

        return $this->redirectToRoute('admin_guest_index');
    }
}

<?php

namespace App\Controller;

use App\Entity\Album;
use App\Repository\UserRepository;
use App\Repository\AlbumRepository;
use App\Repository\MediaRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;

class HomeController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private AlbumRepository $albumRepository,
        private MediaRepository $mediaRepository
    ) {}

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('front/home.html.twig');
    }

    #[Route('/guests', name: 'guests')]
    public function guests(): Response
    {
        $arrayMediaPerGuest = [];

        $guests = $this->userRepository->findBy(['admin' => false]);

        foreach ($guests as $guest) {
            /** @var int */
            $userId = $guest->getId();
            $mediaCount = $this->mediaRepository->countMediaByUser($userId);
            $arrayMediaPerGuest[] = [
                'user' => $guest,
                'numberMedia' => $mediaCount
            ];
        }

        return $this->render('front/guests.html.twig', [
            'guests' => $guests,
            'arrayMediaPerGuest' => $arrayMediaPerGuest
        ]);
    }

    #[Route('/guests/{id}', name: 'guest')]
    public function guest(int $id): Response
    {
        $guest = $this->userRepository->find($id);
        return $this->render('front/guest.html.twig', [
            'guest' => $guest
        ]);
    }

    #[Route('/portfolio/{id}', name: 'portfolio')]
    public function portfolio(?int $id = null): Response
    {
        $albums = $this->albumRepository->findAll();
        $album = $id ? $this->albumRepository->find($id) : null;
        $user = $this->userRepository->findOneByAdmin(true);

        $medias = $album
            ? $this->mediaRepository->findByAlbum($album)
            : $this->mediaRepository->findByUser($user);
        return $this->render('front/portfolio.html.twig', [
            'albums' => $albums,
            'album' => $album,
            'medias' => $medias
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('front/about.html.twig');
    }
}

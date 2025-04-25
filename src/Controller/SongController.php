<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Song;
use App\Repository\SongRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Symfony\Component\Cache\Adapter\TagAwareCacheInterface;
use Symfony\Component\Cache\CacheItemInterface;

final class SongController extends AbstractController
{
    // #[Route('api/v1/song', name: 'api_get_app_all_song', methods: ['GET'])]
    // public function getAll(SongRepository $songRepository, SerializerInterface $serializer, TagAwareCacheInterface $cache): JsonResponse
    // {
    //     $idCache = 'getAllSongs';
    //     $jsonData = $cache->get($idCache, function(itemInterface $item) use ($songRepository, $serializer): void {
    //         $item->tag(tags:"songsCache");
    //         $data = $songRepository->findAll();
    //         return $serializer->serialize($songs, 'json');
    //     });
    //     return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    // }

    #[Route('api/v1/song/{id}', name: 'api_get_song', methods: ['GET'])]
    public function getOne(Song $id, SerializerInterface $serializer): JsonResponse
    {
        $jsonData = $serializer->serialize($id, 'json', ['groups' => ['song']]);
        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }

    #[Route('api/v1/song', name: 'api_create_song', methods: ['POST'])]
    public function create(Request $request, UrlGeneratorInterface $urlGenratorInterface, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $song = new Song();
        dd($request->toArray());
        $song->setName($songData['name'] ?? 'N/A');
        // $song->setArtiste($songData['artiste'] ?? 'N/A');
        $entityManager->persist($song);
        $entityManager->flush();

        $location = $urlGenratorInterface->generate('api_get_song', ['id' => $song->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($song, Response::HTTP_CREATED, ['Location' => $location], true);
    }

    #[Route('api/v1/song/{id}', name: 'api_update_song', methods: ['PUT'])]
    public function update(Song $id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $songData = $request->toArray();
        $id->setName($songData['name'] ?? 'N/A');
        // $id->setArtiste($songData['artiste'] ?? 'N/A';
        $entityManager->persist($id);
        $entityManager->flush();

        return new JsonResponse($id, Response::HTTP_NO_CONTENT);
    }

    #[Route('api/v1/song/{id}', name: 'api_delete_song', methods: ['DELETE'])]
    public function delete(
        Song $id, 
        Song $soft,
        EntityManagerInterface $entityManager, 
        Request $request
    ): JsonResponse
    {    

        $params = $request->toArray();
        if (true === $params['hard']) {
            $entityManager->remove($id);
        } else {
            $id->setStatus('off');
            $entityManager->persist($id);
        }
        
        $entityManager->flush();
    
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
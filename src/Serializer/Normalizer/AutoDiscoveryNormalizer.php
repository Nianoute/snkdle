<?php

namespace App\Serializer\Normalizer;

use App\Entity\Song;
use App\Entity\Pool;
use App\Repository\PoolRepository;
use App\Repository\SongRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use ReflectionClass;


class AutoDiscoveryNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer,
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function normalize($object, ?string $format = null, array $context = []): array
    {
        // $data = $this->normalizer->normalize($object, $format, $context);
        // $className = (new ReflectionClass($object))->getShortName();
        // $data['_links'] = [
        //     'up' => [
        //         'method' => ['GET'],
        //         'path' => $this->urlGenerator->generate('api_get_app_all_song'),
        //     ];
        //     "self" => [
        //         'method' => ['GET'],
        //         'path' => $this->urlGenerator->generate('api_get_song', ['id' => $data['id']]),
        //     ];
        // ];
        // return $data;
        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return ($data instanceof Song || $data instanceof Pool) && $format === 'json';
        // TODO: return $data instanceof Object
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Song::class => true, Pool::class => true];
    }
}

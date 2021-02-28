<?php
// api/src/DataProvider/BlogPostItemDataProvider.php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\CompteUserAgence;
use App\Repository\CompteUserAgenceRepository;

final class CompteUserAgenceDataProvider implements ContextAwareCollectionDataProviderInterface, ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $CompteUserAgenceRepository;

    public function __construct(CompteUserAgenceRepository $CompteUserAgenceRepository)
    {
        $this->CompteUserAgenceRepository = $CompteUserAgenceRepository;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return CompteUserAgence::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        // Retrieve the blog post item from somewhere then return it or null if not found
        return $this->CompteUserAgenceRepository->findOneBy(['statut' => false, 'id' => $id]);
    }

    public function getCollection(string $resourceClass, ?string $operationName = null, array $context = [])
    {

        return $this->CompteUserAgenceRepository->findBy(['statut' => false]);
    }
}

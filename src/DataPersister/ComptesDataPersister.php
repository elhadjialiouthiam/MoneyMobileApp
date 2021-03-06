<?php
namespace App\DataPersister;

use App\Entity\Comptes;
use App\Services\UtilsHelper;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ComptesDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_utilsHelper;

    public function __construct(
        EntityManagerInterface $entityManager,
        UtilsHelper $utilsHelper,
    ) {
        $this->_entityManager = $entityManager;
        $this->_utilsHelper = $utilsHelper;
    }

    public function supports($data, array $context = []): bool
    {

        return $data instanceof Comptes;
    }

    public function persist($data, array $context = [])
    {
        $soldeCompte = $data->getCompte()->getSolde();
        $data->getCompte()->setSolde($soldeCompte + 700000);
        $data->setNumCompte($this->_utilsHelper->generateCode());
        // call your persistence layer to save $data
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
        return $data;

    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
        $data->setStatut(true);
        $this->_entityManager->flush();
        return $data;
    }
}

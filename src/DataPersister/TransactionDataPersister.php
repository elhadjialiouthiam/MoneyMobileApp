<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Transaction;
use App\Services\TransactionHelper;
use App\Services\UtilsHelper;
use Container6NLTnp5\getClientsRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TransactionDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_passwordEncoder;
    private $_transactionHelper;
    private $_utilsHelper;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        TransactionHelper $transactionHelper,
        UtilsHelper $utilsHelper
    ) {
        $this->_entityManager = $entityManager;
        $this->_passwordEncoder = $passwordEncoder;
        $this->_transactionHelper = $transactionHelper;
        $this->_utilsHelper = $utilsHelper;

    }

    public function supports($data, array $context = []): bool
    {

        return $data instanceof Transaction;
    }

    public function persist($data, array $context = [])
    {
        // call your persistence layer to save $data
        $frais = $this->_transactionHelper->calculateFrais($data->getMontant());
        $data->setFrais($frais);
        $data->setCode($this->_utilsHelper->generateCode());
        $parts = $this->_transactionHelper->calculateCommissions($frais);
        $data->setPartEtat($parts['partEtat']);
        $data->setPartAgenceRetrait($parts['operateurRetrait']);
        $data->setPartAgenceDepot($parts['operateurDepot']);

        $soldeCompte = $data->getCompte()->getSolde();
        $soldeTransmis = $data->getMontant() - $frais;
        $soldeCompteUser= $data->getCompteUserAgence()->getSolde();
        $soleTransmisUser= $data->getMontant() + $frais ;
        if ($data->getIsDepot()) {
            $data->getCompte()->setSolde($soldeCompte - $soldeTransmis + $parts['operateurDepot']);
            $data->getCompteUserAgence()->setSolde($soldeCompteUser + $data->getMontant());
        } else {
            $data->getCompte()->setSolde($soldeCompte + $soldeTransmis + $parts['operateurRetrait']);
            $data->getCompteUserAgence()->setSolde($soldeCompteUser - $soleTransmisUser);
        }
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
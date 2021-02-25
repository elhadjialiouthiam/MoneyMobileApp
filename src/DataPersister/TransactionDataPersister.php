<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Transaction;
use App\Services\TransactionHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TransactionDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_passwordEncoder;
    private $_transactionHelper;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        TransactionHelper $transactionHelper
    ) {
        $this->_entityManager = $entityManager;
        $this->_passwordEncoder = $passwordEncoder;
        $this->_transactionHelper = $transactionHelper;
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
        $parts = $this->_transactionHelper->calculateCommissions($frais);
        $data->setPartEtat($parts['partEtat']);
        $data->setPartAgenceRetrait($parts['operateurRetrait']);
        $data->setPartAgenceDepot($parts['operateurDepot']);

        // dd($data);
        $soldeCompte = $data->getCompte()->getMontant();
        $soldeTransmis = $data->getMontant() - $frais;
        if ($data->getIsDepot()) {
            $data->getCompte()->setMontant($soldeCompte + $soldeTransmis);
        } else {
            $data->getCompte()->setMontant($soldeCompte - $soldeTransmis);
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

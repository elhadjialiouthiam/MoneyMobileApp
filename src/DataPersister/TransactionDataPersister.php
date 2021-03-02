<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Transaction;
use App\Services\TransactionHelper;
use App\Services\UtilsHelper;
use App\Services\SendSms;
use Container6NLTnp5\getClientsRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Notifier\Message\SentMessage;

class TransactionDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_transactionHelper;
    private $_utilsHelper;
    private $_send_sms;

    public function __construct(
        EntityManagerInterface $entityManager,
        TransactionHelper $transactionHelper,
        UtilsHelper $utilsHelper,
        SendSms $send_sms,
    ) {
        $this->_entityManager = $entityManager;
        $this->_transactionHelper = $transactionHelper;
        $this->_utilsHelper = $utilsHelper;
        $this->_send_sms = $send_sms;

    }

    public function supports($data, array $context = []): bool
    {

        return $data instanceof Transaction;
    }

    public function persist($data, array $context = [])
    {
        // call your persistence layer to save $data
        $frais = $this->_transactionHelper->calculateFrais($data->getMontant());
        $data->setCode($this->_utilsHelper->generateCode());
        
        if ($data->getIsDepot()) {
            if ($data->getIsClient()){
                $data->setFrais($frais);
                $parts = $this->_transactionHelper->calculateCommissions($frais);
                $data->setPartEtat($parts['partEtat']);
                $data->setPartSysteme($parts['partSysteme']);
                $data->setPartAgenceDepot($parts['operateurDepot']);
                $soldeCompte = $data->getCompte()->getSolde();
                $soldeTransmis = $data->getMontant() - $frais;
            $data->getCompte()->setSolde($soldeCompte - $soldeTransmis + $parts['operateurDepot']);
            }else{
                $data->setFrais($frais);
                $parts = $this->_transactionHelper->calculateCommissions($frais);
                $soldeCompte = $data->getCompte()->getSolde();
                $soldeTransmis = $data->getMontant() ;
                $soleTransmisUser= $data->getMontant() ;
            $soldeCompteUser= $data->getCompteUserAgence()->getSolde();
            $data->getCompte()->setSolde($soldeCompte - $soldeTransmis);
            $data->getCompteUserAgence()->setSolde($soldeCompteUser + $data->getMontant());
            }
        } else {
            if ($data->getIsClient()){
                $data->setFrais($frais);
            $parts = $this->_transactionHelper->calculateCommissions($frais);
            $data->setPartAgenceRetrait($parts['operateurRetrait']);
            $soldeCompte = $data->getCompte()->getSolde();
            $soldeTransmis = $data->getMontant();
            $data->getCompte()->setSolde($soldeCompte + $soldeTransmis + $parts['operateurRetrait']);
            }else{
                $data->setFrais($frais);
            $parts = $this->_transactionHelper->calculateCommissions($frais);
            $data->setPartEtat($parts['partEtat']);
            $data->setPartSysteme($parts['partSysteme']);
            $data->setPartAgenceRetrait($parts['operateurRetrait']);
            $soldeCompte = $data->getCompte()->getSolde();
            $soldeTransmis = $data->getMontant() ;
            $soleTransmisUser= $data->getMontant() + $frais ;
            $soldeCompteUser= $data->getCompteUserAgence()->getSolde();
            $data->getCompte()->setSolde($soldeCompte + $soldeTransmis + $parts['operateurRetrait']);
            $data->getCompteUserAgence()->setSolde($soldeCompteUser - $soleTransmisUser);
            }
        }
        // $this->_send_sms->send();
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
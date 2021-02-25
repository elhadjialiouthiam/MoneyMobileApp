<?php
namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Comptes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ComptesDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->_entityManager = $entityManager;
        $this->_passwordEncoder = $passwordEncoder;
    }

    public function supports($data, array $context = []): bool
    {

        return $data instanceof Comptes;
    }

    public function persist($data, array $context = [])
    {
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

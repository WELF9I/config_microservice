<?php

namespace App\Controller;
use Doctrine\ORM\EntityRepository;

use App\Entity\Configuration; 
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class ConfigController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/config", name="config")
     */
    public function index(): Response
    {
        // Fetch configuration settings from the database
        $config = $this->getConfigFromDatabase();

        // Return configuration as JSON response
        return $this->json($config);
    }

    private function getConfigFromDatabase(): array
    {
        $config = [];
        
        // Fetch configuration data from the database
        $configurationRepository = $this->entityManager->getRepository(\Doctrine\ORM\EntityRepository::class);
        $configurationItems = $configurationRepository->findAll();

        // Process configuration items
        foreach ($configurationItems as $item) {
            $config[$item->getKey()] = $item->getValue();
        }

        return $config;
    }
}

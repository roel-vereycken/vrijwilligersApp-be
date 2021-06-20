<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Opmerking;
use App\Services\TextAreaService;
use Doctrine\ORM\EntityManagerInterface;

class OpmerkingDataPersister implements DataPersisterInterface
{
    private $entityManager;

    private $textAreaService;

    public function __construct(EntityManagerInterface $entityManager, textAreaService $textAreaService)
    {
        $this->entityManager = $entityManager;

        $this->textAreaService = $textAreaService;
    }

    public function supports($data): bool
    {
        return $data instanceof Opmerking;
    }

    /**
     * @param Opmerking $data
     */
    public function persist($data)
    {
        if ($data->getBody()) {
            $data->setBody(
                $this->textAreaService->stripTags($data)
            );
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
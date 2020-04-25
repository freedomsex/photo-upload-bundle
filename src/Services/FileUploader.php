<?php


namespace FreedomSex\PhotoUploadBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use FreedomSex\PhotoUploadBundle\Entity\FileInterface;
use FreedomSex\PhotoUploadBundle\Services\FilterService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Handler\UploadHandler;

class FileUploader
{
    public function __construct(
        FilterService $filterService,
//        UploadHandler $uploadHandler,
        EntityManagerInterface $entityManager
    ) {
        $this->filterService = $filterService;
//        $this->uploadHandler = $uploadHandler;
        $this->entityManager = $entityManager;
    }

    public function upload(UploadedFile $file, FileInterface $entity)
    {
        $realPath = $file->getRealPath();
        $image = $this->filterService->prepare($realPath);
        $extension = $image->getFormat();

        [$width, $height] = getimagesize($realPath);
        $sizes = [$width, $height];

        $entity->setAdded(new \DateTime());

        $entity->setWidth($width);
        $entity->setHeight($height);

        $entity->setExtension($extension);
        $entity->setImageFile($file);
//        $this->uploadHandler->upload($entity, 'imageFile');

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}

<?php

namespace FreedomSex\PhotoUploadBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileInterface
{
    public function getId(): ?int;

    public function setFile(string $file);

    public function getFile(): ?string;

    /**
     * @param File|UploadedFile $image
     */
    public function setImageFile(File $image = null);

    /**
     * @return File|null
     */
    public function getImageFile();

    public function setWidth(int $width);

    public function getWidth(): ?int;

    public function setHeight(int $height);

    public function getHeight(): ?int;

    public function setExtension(string $ext);

    public function getExtension(): ?string;

    public function setFileSize(int $size);

    public function getFileSize(): ?int;

    public function setAdded(\DateTimeInterface $added);

    public function getAdded(): ?\DateTimeInterface;

}

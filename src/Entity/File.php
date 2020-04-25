<?php


namespace FreedomSex\PhotoUploadBundle\Entity;


use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File as HttpFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass()
 * @Vich\Uploadable
 */
abstract class File implements FileInterface
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $file;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(
     *     mapping="uploads",
     *     fileNameProperty="file",
     *     size="fileSize"
     * )
     *
     * @Assert\Image(
     *     maxSize = "15M",
     *     mimeTypes = {"image/jpeg"},
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     *
     * @var HttpFile
     */
    private $imageFile;


    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $width;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=4)
     */
    private $extension;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $fileSize;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $added;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    /**
     * @param HttpFile|UploadedFile $image
     */
    public function setImageFile(HttpFile $image = null)
    {
        $this->imageFile = $image;

        return $this;
    }

    /**
     * @return HttpFile|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setFileSize(int $fileSize): self
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setAdded(\DateTimeInterface $added): self
    {
        $this->added = $added;

        return $this;
    }

    public function getAdded(): ?\DateTimeInterface
    {
        return $this->added;
    }

}

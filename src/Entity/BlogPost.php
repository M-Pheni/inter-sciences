<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\BlogPostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=BlogPostRepository::class)
 * @ORM\Table(name="blog_posts")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class BlogPost
{
    use Timestampable;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Le Titre d'un article ne peu pas être vide !")
     * @Assert\Length(min=4, minMessage = "Le titre d'un article doit faire au minimun 4 caractères !")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "Le Contenue d'un article ne peu pas être vide !")
     * @Assert\Length(min=3, minMessage = "Le Contenue de l'article doit faire au minimun 500 caractères !")
     */
    private $content;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="post_image", fileNameProperty="imageName")
     * @Assert\Image(maxSize="5M")
     * 
     * @var File|null
     */
     private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
     public function setImageFile(?File $imageFile = null): void
     {
         $this->imageFile = $imageFile;
 
         if (null !== $imageFile) {
             // It is required that at least one field changes if you are using doctrine
             // otherwise the event listeners won't be called and the file is lost
             $this->setUpdatedAt(new \DateTimeImmutable);
         }
     }
 
     public function getImageFile(): ?File
     {
         return $this->imageFile;
     }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }
}

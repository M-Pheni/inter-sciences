<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\BlogPostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BlogPostRepository::class)
 * @ORM\Table(name="blog_posts")
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
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UriRepository")
 */
class Uri
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $longUri;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $shortUri;

    public static function create(string $shortUri, string $longUri): self
    {
        $new = new self();
        $new->shortUri = $shortUri;
        $new->longUri = $longUri;

        return $new;
    }

    public function id(): \Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }

    public function longUri(): ?string
    {
        return $this->longUri;
    }

    public function shortUri(): ?string
    {
        return $this->shortUri;
    }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TriadRepository")
 */
class Triad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $root;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $third;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fifth;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoot(): ?string
    {
        return $this->root;
    }

    public function setRoot(string $root): self
    {
        $this->root = $root;

        return $this;
    }

    public function getThird(): ?string
    {
        return $this->third;
    }

    public function setThird(string $third): self
    {
        $this->third = $third;

        return $this;
    }

    public function getFifth(): ?string
    {
        return $this->fifth;
    }

    public function setFifth(string $fifth): self
    {
        $this->fifth = $fifth;

        return $this;
    }
}

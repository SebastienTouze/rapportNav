<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LoisirRepository")
 */
class Loisir implements JsonSerializable {
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $nom;

  public function jsonSerialize() {
    return [
        'id' => $this->getId(),
      'nom' => $this->getNom()
    ];
  }

  public function getId(): ?int {
    return $this->id;
  }

  public
  function getNom(): ?string {
    return $this->nom;
  }

  public
  function setNom(string $nom): self {
    $this->nom = $nom;

    return $this;
  }
}


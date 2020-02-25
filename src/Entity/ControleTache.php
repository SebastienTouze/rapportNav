<?php

namespace App\Entity;

use App\Helper\TimeConvert;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ControleTacheRepository")
 */
class ControleTache implements JsonSerializable {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MissionAdministratif", inversedBy="taches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rapport;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombreDossiers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tache")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tache;

    /**
     * @ORM\Column(type="integer")
     */
    private $dureeTache;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $detailTache;

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'tache' => $this->getTache()->getId(),
            'detailTache' => $this->getDetailTache(),
            'showDetail' => "Autre" === $this->getTache()->getNom(),
            'dureeTache' => TimeConvert::minutesToTime($this->getDureeTache())->format("H:i"),
            'nombreDossiers' => $this->getNombreDossiers(),
        ];
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getTache(): ?Tache {
        return $this->tache;
    }

    public function setTache(?Tache $tache): self {
        $this->tache = $tache;

        return $this;
    }

    public function getRapport(): ?MissionAdministratif {
        return $this->rapport;
    }

    public function setRapport(?MissionAdministratif $rapport): self {
        $this->rapport = $rapport;

        return $this;
    }

    public function getDureeTache(): ?int {
        return $this->dureeTache;
    }

    public function setDureeTache(int $dureeTache): self {
        $this->dureeTache = $dureeTache;

        return $this;
    }

    public function getNombreDossiers(): ?int {
        return $this->nombreDossiers;
    }

    public function setNombreDossiers(?int $nombreDossiers): self {
        $this->nombreDossiers = $nombreDossiers;

        return $this;
    }

    public function getDetailTache(): ?string {
        return $this->detailTache;
    }

    public function setDetailTache(?string $detailTache): self {
        $this->detailTache = $detailTache;

        return $this;
    }
}

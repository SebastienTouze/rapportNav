<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ControleNavireRepository")
 */
class ControleNavire implements JsonSerializable {

    use RapportControle;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ActiviteNavire", inversedBy="navires")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     */
    private $activite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Navire", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     */
    private $navire;

    /**
     * @ORM\Column(type="boolean")
     */
    private $terrestre;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=8, nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=8, nullable=true)
     */
    private $long;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CategorieControleNavire")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     */
    private $controleNavireRealises;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $detailControle;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Assert\NotBlank()
     */
    private $date;

    /**
     * @ORM\Column(type="boolean", options={"default" : 0})
     */
    private $aireProtegee = false;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default": 0})
     */
    private $chloredeconeTotal = false;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default": 0})
     */
    private $chloredeconePartiel = false;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     */
    private $pv = false;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Natinf", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $natinfs;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieDeroutement")
     */
    private $deroutement;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pingerApplicable;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pingerPresent;

    public function jsonSerialize() {
        $data = [
            'pv' => $this->getPv(),
            'terrestre' => $this->getTerrestre(),
            'aireProtegee' => $this->getAireProtegee(),
            'chloredeconeTotal' => $this->getChloredeconeTotal(),
            'chloredeconePartiel' => $this->getChloredeconePartiel(),
            'pingerApplicable' => $this->getPingerApplicable(),
            'pingerPresent' => $this->getPingerPresent(),
            'date' => $this->getDate()->format("Y-m-d H:i"),
            'lat' => $this->getLat(),
            'long' => $this->getLong(),
            'detailControle' => $this->getDetailControle(),
            'isDeroutement' => null !== $this->getDeroutement(),
            'deroutement' => ($this->getDeroutement()) ? $this->getDeroutement()->getId() : null,
            'commentaire' => $this->getCommentaire()
        ];


        $data['natinfs'] = [];
        foreach ($this->getNatinfs() as $natinf) {
            $data['natinfs'][] = $natinf->getNumero();
        }

        $data['navire'] = $this->getNavire();

        $data['controleNavireRealises'] = [];

        $data['showDetail'] = false;
        foreach ($this->getControleNavireRealises() as $controle) {
            $data['controleNavireRealises'][] = $controle->getId();
            if ("Autre" === $controle->getNom()) {
                $data['showDetail'] = true;
            }
        }

        return $data;
    }

    public function __construct() {
        $this->controleNavireRealises = new ArrayCollection();
        $this->natinfs = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNavire(): ?Navire {
        return $this->navire;
    }

    public function setNavire(?Navire $navire): self {
        $this->navire = $navire;

        return $this;
    }

    public function getPv(): bool {
        return $this->pv;
    }

    public function setPv(bool $pv): self {
        $this->pv = $pv;

        return $this;
    }

    public function getActivite(): ?Activite {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): self {
        $this->activite = $activite;

        return $this;
    }

    public function getCommentaire(): ?string {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * @return Collection|Natinf[]
     */
    public function getNatinfs(): Collection {
        return $this->natinfs;
    }

    public function addNatinf(Natinf $natinf): self {
        if (!$this->natinfs->contains($natinf)) {
            $this->natinfs[] = $natinf;
        }

        return $this;
    }

    public function removeNatinf(Natinf $natinf): self {
        if ($this->natinfs->contains($natinf)) {
            $this->natinfs->removeElement($natinf);
        }

        return $this;
    }

    /**
     * @return Collection|CategorieControleNavire[]
     */
    public function getControleNavireRealises(): Collection {
        return $this->controleNavireRealises;
    }

    public function addControleNavireRealise(CategorieControleNavire $controleNavire): self {
        if (!$this->controleNavireRealises->contains($controleNavire)) {
            $this->controleNavireRealises[] = $controleNavire;
        }

        return $this;
    }

    public function removeControleNavireRealise(CategorieControleNavire $controleNavire): self {
        if ($this->controleNavireRealises->contains($controleNavire)) {
            $this->controleNavireRealises->removeElement($controleNavire);
        }

        return $this;
    }

    public function getAireProtegee(): ?bool {
        return $this->aireProtegee;
    }

    public function setAireProtegee(bool $aireProtegee): self {
        $this->aireProtegee = $aireProtegee;

        return $this;
    }

    public function getDate(): ?DateTimeImmutable {
        return $this->date;
    }

    public function setDate(?DateTimeImmutable $date): self {
        $this->date = $date;

        return $this;
    }

    public function getTerrestre() {
        return $this->terrestre;
    }

    public function setTerrestre($terrestre): self {
        $this->terrestre = $terrestre;
        return $this;
    }

    public function getLat(): ?string {
        return $this->lat;
    }

    public function setLat(?string $lat): self {
        $this->lat = $lat;

        return $this;
    }

    public function getLong(): ?string {
        return $this->long;
    }

    public function setLong(?string $long): self {
        $this->long = $long;

        return $this;
    }

    public function getDeroutement(): ?CategorieDeroutement {
        return $this->deroutement;
    }

    public function setDeroutement(?CategorieDeroutement $deroutement): self {
        $this->deroutement = $deroutement;

        return $this;
    }

    public function getChloredeconeTotal(): ?bool {
        return $this->chloredeconeTotal;
    }

    public function setChloredeconeTotal(bool $chloredeconeTotal): self {
        $this->chloredeconeTotal = $chloredeconeTotal;

        return $this;
    }

    public function getChloredeconePartiel(): ?bool {
        return $this->chloredeconePartiel;
    }

    public function setChloredeconePartiel(bool $chloredeconePartiel): self {
        $this->chloredeconePartiel = $chloredeconePartiel;

        return $this;
    }

    public function getDetailControle(): ?string {
        return $this->detailControle;
    }

    public function setDetailControle(?string $detailControle): self {
        $this->detailControle = $detailControle;

        return $this;
    }

    public function getPingerApplicable(): ?bool {
        return $this->pingerApplicable;
    }

    public function setPingerApplicable(?bool $pingerApplicable): self {
        $this->pingerApplicable = $pingerApplicable;

        return $this;
    }

    public function getPingerPresent(): ?bool {
        return $this->pingerPresent;
    }

    public function setPingerPresent(?bool $pingerPresent): self {
        $this->pingerPresent = $pingerPresent;

        return $this;
    }

}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipantRepository")
 */
class Participant
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $profession;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $province;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estMembreBpi;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estPresentateur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titrePresentation;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $galaOption;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Civilite", inversedBy="participants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $civilite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(string $province): self
    {
        $this->province = $province;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getEstMembreBpi()
    {
        return $this->estMembreBpi;
    }

    public function setEstMembreBpi(bool $estMembreBpi): self
    {
        $this->estMembreBpi = $estMembreBpi;

        return $this;
    }

    public function getEstPresentateur()
    {
        return $this->estPresentateur;
    }

    public function setEstPresentateur(bool $estPresentateur): self
    {
        $this->estPresentateur = $estPresentateur;

        return $this;
    }

    public function getTitrePresentation(): ?string
    {
        return $this->titrePresentation;
    }

    public function setTitrePresentation(string $titrePresentation): self
    {
        $this->titrePresentation = $titrePresentation;

        return $this;
    }

    public function getCivilite(): ?Civilite
    {
        return $this->civilite;
    }

    public function setCivilite(?Civilite $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getGalaOption()
    {
        return $this->galaOption;
    }

    public function setGalaOption(bool $galaOption): self
    {
        $this->galaOption = $galaOption;

        return $this;
    }
}

<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 *  @ApiResource(
 *     denormalizationContext={"groups"={"ref_write"}},
 *     normalizationContext={"groups"={"refs_read"}},
 *     routePrefix="/admin",
 *     collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/referentiels",
 *             "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     },
 *          "getrefgrpcom"={
 *              "method"="GET",
 *              "path"="/referentiels/grpecompetences",
 *             "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     },
 *          "post"={
 *              "method"="POST",
 *              "path"="/referentiels",
 *             "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *             "security_message"="vous n'avez pas acces",
 *     }
 *     },
 *      itemOperations={
 *            "getItemp"={
 *              "method"="GET",
 *              "path"="/referentiels/{id}",
 *             "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     },
 *            "getItempref"={
 *              "method"="GET",
 *              "path"="/referentiels/{idref}/grpecompetences/{idgrp}",
 *             "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     },
 *          "put"={
 *              "method"="PUT",
 *              "path"="/referentiels/{id}",
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas l'acces"
 *     }
 *     }
 * )
 */
class Referentiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="Champ libelle vide"
     * )
     * @Groups({"ref_write"})
     * @Groups({"refs_read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"ref_write"})
     * @Groups({"refs_read"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="blob")
     * @Groups({"ref_write"})
     * @Groups({"refs_read"})
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"ref_write"})
     * @Groups({"refs_read"})
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"ref_write"})
     * @Groups({"refs_read"})
     */
    private $critereAdmission;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archived=false;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetences::class, inversedBy="referentiels")
     * @Groups({"ref_write"})
     * @Groups({"refs_read"})
     */
    private $groupeCompetences;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="refereftiels")
     */
    private $promos;


    public function __construct()
    {
        $this->referentiels = new ArrayCollection();
        $this->groupeCompetences = new ArrayCollection();
        $this->promos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme()
    {
        if ($this->programme!==null) {
            $content = \stream_get_contents($this->programme);
            fclose($this->programme);

            return base64_encode($content);
        }
        return null;
    }

    public function setProgramme($programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(?string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    public function getCritereAdmission(): ?string
    {
        return $this->critereAdmission;
    }

    public function setCritereAdmission(?string $critereAdmission): self
    {
        $this->critereAdmission = $critereAdmission;

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * @return Collection|GroupeCompetences[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        $this->groupeCompetences->removeElement($groupeCompetence);

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->addRefereftiel($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            $promo->removeRefereftiel($this);
        }

        return $this;
    }


}

<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupeCompetencesRepository::class)
 *  @ApiResource(
 * attributes={"force_eager"=false,"denormalization_context"={"groups"={"denom"},"enable_max_depth"=true}},
 *     denormalizationContext={"groups"={"grpecompetence_write"}},
*      normalizationContext={"groups"={"grpec_read"}},
 *     routePrefix="/admin",
 *     collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/grpecompetences",
 *             "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *              "normalization_context"={"groups"={"normgrp_red"}},
 *             "security_message"="vous n'avez pas acces",
 *     },
 *        "getgpCo"={
 *              "method"="GET",
 *              "path"="/grpecompetences/competences",
 *             "security"="is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     },
 *        "post"={
 *              "method"="POST",
 *              "path"="/grpecompetences",
 *             "security"="is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     }
 *     },
 *    itemOperations={
 *          "getItem"={
 *              "method"="GET",
 *              "path"="/grpecompetences/{id}",
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas l'acces"
 *     },
 *          "getItemid"={
 *              "method"="GET",
 *              "path"="/grpecompetences/{id}/competences",
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas l'acces"
 *     },
 *          "put"={
 *              "method"="PUT",
 *              "path"="/grpecompetences/{id}",
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas l'acces"
 *     }
 *     },
 * )
 */
class GroupeCompetences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"grpec_read","normgrp_red"})
     * @Groups({"competence_read","comp_write"})
     *  @Groups({"competence_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(
     *     message="Champ libelle vide"
     * )
     * @Groups({"grpecompetence_write","denom"})
     * @Groups({"grpec_read","normgrp_red"})
     * @Groups({"ref_write"})
     * @Groups({"refs_read"})
     * @Groups({"competence_read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"grpecompetence_write", "denom"})
     * @Groups({"ref_write"})
     * @Groups({"refs_read"})
     * @Groups({"competence_read"})
     * @Groups({"grpec_read","normgrp_red"})
     */
    private $description;
    
    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="groupeCompetences")
     */
    private $referentiels;

    /**
     * @ORM\ManyToMany(targetEntity=Competences::class, mappedBy="groupeCompetence", cascade={"persist"})
     * @MaxDepth(1)
     * @Groups({"comp_write"})
     * @Groups({"grpecompetence_write"})
     * @Groups({"grpec_read","normgrp_red"})
     */
    private $competences;


    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->groupeCompetences = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGroupeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            $referentiel->removeGroupeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|Competences[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competences $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->addGroupeCompetence($this);
        }

        return $this;
    }

    public function removeCompetence(Competences $competence): self
    {
        if ($this->competences->removeElement($competence)) {
            $competence->removeGroupeCompetence($this);
        }

        return $this;
    }
}

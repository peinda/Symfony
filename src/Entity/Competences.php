<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use App\Repository\CompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetencesRepository::class)
 *  @ApiResource(
 *     denormalizationContext={"groups"={"comp_write"}},
 *     normalizationContext={"groups"={"competence_read"}}, 
 *     routePrefix="/admin",
 *     collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/competences",
 *             "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     },
 *          "post"={
 *              "method"="POST",
 *              "path"="/competences",
 *             "security"="is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     }
 *     },
 *      itemOperations={
 *            "getItemp"={
 *              "method"="GET",
 *              "path"="/competences/{id}",
 *             "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     },
 *        "put"={
 *        "method"="PUT",
 *          "path"="/competences/{id}",
 *             "security"="is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     }
 *     }
 * )
 */
class Competences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"grpec_read", "normgrp_red"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(
     *     message="Champ libelle vide"
     * )
     * @Groups({"competence_read"})
     * @Groups({"comp_write"})
     * @Groups({"grpecompetence_write"})
     * @Groups({"grpec_read", "normgrp_red"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"competence_read"})
     * @Groups({"comp_write"})
     * @Groups({"grpecompetence_write"})
     * @Groups({"grpec_read"})
     */
    private $archived=false;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competence_read"})
     * @Groups({"comp_write"})
     * @Groups({"grpecompetence_write"})
     * @Groups({"grpec_read"})
     */
    private $descriptif;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="niveau", cascade={"persist"})
     * @Groups({"competence_write"})
     * @Assert\Count(
     *      min = 3,
     *      max = 3,
     *      minMessage = "les niveaux ne doivent pas etre moins de 3",
     *      maxMessage = "les niveaux ne doivent pas etre plus de 3"
     * )
     * @Groups({"competence_read"})
     * @Groups({"comp_write"})
     * @Groups({"grpecompetence_write"})
     * @Groups({"grpec_read"})
     */
    private $niveaux;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetences::class, inversedBy="competences", cascade={"persist"})
     * @Groups({"competence_read"})
     * @Groups({"comp_write"})
     */
    private $groupeCompetence;


    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
        $this->groupeCompetence = new ArrayCollection();
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

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->setNiveau($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getNiveau() === $this) {
                $niveau->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GroupeCompetences[]
     */
    public function getGroupeCompetence(): Collection
    {
        return $this->groupeCompetence;
    }

    public function addGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if (!$this->groupeCompetence->contains($groupeCompetence)) {
            $this->groupeCompetence[] = $groupeCompetence;
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        $this->groupeCompetence->removeElement($groupeCompetence);

        return $this;
    }

}
<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\NiveauRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 *  @ApiResource()
 */
class Niveau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"competence_read"})
     * @Groups({"comp_write", "grpecompetence_write","grpec_read"})
     */
    private $libelle;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"competence_read"})
     * @Groups({"comp_write", "grpecompetence_write","grpec_read"})
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"competence_read"})
     * @Groups({"comp_write", "grpecompetence_write","grpec_read"})
     */
    private $groupeAction;

    /**
     * @ORM\ManyToOne(targetEntity=Competences::class, inversedBy="niveaux", cascade={"persist"})
     * @Assert\Count(
     *      min = 3,
     *      max = 3,
     *      minMessage = "les niveaux ne doivent pas etre moins de 3",
     *      maxMessage = "les niveaux ne doivent pas etre de 3"
     * )
     */
    private $niveau;

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

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(?string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    public function getGroupeAction(): ?string
    {
        return $this->groupeAction;
    }

    public function setGroupeAction(?string $groupeAction): self
    {
        $this->groupeAction = $groupeAction;

        return $this;
    }

    public function getNiveau(): ?Competences
    {
        return $this->niveau;
    }

    public function setNiveau(?Competences $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }
}

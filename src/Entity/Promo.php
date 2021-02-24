<?php

namespace App\Entity;

use App\Repository\PromoRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 *  @ApiResource(
 *     denormalizationContext={"groups"={"promo_write"}},
 *     normalizationContext={"groups"={"promos_read"}},
 *     routePrefix="/admin",
 *     collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/promo",
 *             "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     },
 *          "post"={
 *              "method"="Post",
 *              "path"="/promo",
 *              "route_name"="createPromo",
 *             "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     }
 *     }
 *     )
 */
class Promo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"promo_write"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"promo_write"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"promo_write"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"promo_write"})
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"promo_write"})
     */
    private $referenceAgate;

    /**
     * @ORM\Column(type="date")
     * @Groups({"promo_write"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     * @Groups({"promo_write"})
     */
    private $dateFinProvisoire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"promo_write"})
     */
    private $fabrique;

    /**
     * @ORM\Column(type="date")
    * @Groups({"promo_write"})
     */
    private $dateFinReelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promo_write"})
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $users;

  

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="promos")
     */
    private $formateurs;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promos")
     */
    private $groupes;

    /**
     * @ORM\OneToMany(targetEntity=FileDiscussion::class, mappedBy="promo")
     */
    private $fileDiscussions;

    /**
     * @ORM\OneToMany(targetEntity=PromoBrief::class, mappedBy="promo")
     */
    private $promoBriefs;

    /**
     * @ORM\OneToMany(targetEntity=StatiquesCompetences::class, mappedBy="promo")
     */
    private $statiqueCompetences;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="promo")
     */
    private $apprenants;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, inversedBy="promos")
     */
    private $refereftiels;

    public function __construct()
    {
        $this->formateurs = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->fileDiscussions = new ArrayCollection();
        $this->promoBriefs = new ArrayCollection();
        $this->statiqueCompetences = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
        $this->refereftiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(?string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

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

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getReferenceAgate(): ?string
    {
        return $this->referenceAgate;
    }

    public function setReferenceAgate(?string $referenceAgate): self
    {
        $this->referenceAgate = $referenceAgate;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFinProvisoire(): ?\DateTimeInterface
    {
        return $this->dateFinProvisoire;
    }

    public function setDateFinProvisoire(\DateTimeInterface $dateFinProvisoire): self
    {
        $this->dateFinProvisoire = $dateFinProvisoire;

        return $this;
    }

    public function getFabrique(): ?string
    {
        return $this->fabrique;
    }

    public function setFabrique(?string $fabrique): self
    {
        $this->fabrique = $fabrique;

        return $this;
    }

    public function getDateFinReelle(): ?\DateTimeInterface
    {
        return $this->dateFinReelle;
    }

    public function setDateFinReelle(\DateTimeInterface $dateFinReelle): self
    {
        $this->dateFinReelle = $dateFinReelle;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

   
    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        $this->formateurs->removeElement($formateur);

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setPromos($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getPromos() === $this) {
                $groupe->setPromos(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FileDiscussion[]
     */
    public function getFileDiscussions(): Collection
    {
        return $this->fileDiscussions;
    }

    public function addFileDiscussion(FileDiscussion $fileDiscussion): self
    {
        if (!$this->fileDiscussions->contains($fileDiscussion)) {
            $this->fileDiscussions[] = $fileDiscussion;
            $fileDiscussion->setPromo($this);
        }

        return $this;
    }

    public function removeFileDiscussion(FileDiscussion $fileDiscussion): self
    {
        if ($this->fileDiscussions->removeElement($fileDiscussion)) {
            // set the owning side to null (unless already changed)
            if ($fileDiscussion->getPromo() === $this) {
                $fileDiscussion->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PromoBrief[]
     */
    public function getPromoBriefs(): Collection
    {
        return $this->promoBriefs;
    }

    public function addPromoBrief(PromoBrief $promoBrief): self
    {
        if (!$this->promoBriefs->contains($promoBrief)) {
            $this->promoBriefs[] = $promoBrief;
            $promoBrief->setPromo($this);
        }

        return $this;
    }

    public function removePromoBrief(PromoBrief $promoBrief): self
    {
        if ($this->promoBriefs->removeElement($promoBrief)) {
            // set the owning side to null (unless already changed)
            if ($promoBrief->getPromo() === $this) {
                $promoBrief->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StatiquesCompetences[]
     */
    public function getStatiqueCompetences(): Collection
    {
        return $this->statiqueCompetences;
    }

    public function addStatiqueCompetence(StatiquesCompetences $statiqueCompetence): self
    {
        if (!$this->statiqueCompetences->contains($statiqueCompetence)) {
            $this->statiqueCompetences[] = $statiqueCompetence;
            $statiqueCompetence->setPromo($this);
        }

        return $this;
    }

    public function removeStatiqueCompetence(StatiquesCompetences $statiqueCompetence): self
    {
        if ($this->statiqueCompetences->removeElement($statiqueCompetence)) {
            // set the owning side to null (unless already changed)
            if ($statiqueCompetence->getPromo() === $this) {
                $statiqueCompetence->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->setPromo($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getPromo() === $this) {
                $apprenant->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    public function getRefereftiels(): Collection
    {
        return $this->refereftiels;
    }

    public function addRefereftiel(Referentiel $refereftiel): self
    {
        if (!$this->refereftiels->contains($refereftiel)) {
            $this->refereftiels[] = $refereftiel;
        }

        return $this;
    }

    public function removeRefereftiel(Referentiel $refereftiel): self
    {
        $this->refereftiels->removeElement($refereftiel);

        return $this;
    }
}

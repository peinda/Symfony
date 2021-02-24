<?php

namespace App\Entity;

use App\Entity\ProfilDeSortie;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilDeSortieRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProfilDeSortieRepository::class)
 *   @ApiResource(
 *      routePrefix="/admin",
 *      normalizationContext={"groups"={"profilSortie:get"}},
 *     collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/profilsortie",
 *              "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous n'avez pas l'acces"
 *     },
 *           "post"={
 *              "method"="POST",
 *              "path"="/profilsortie",
 *              "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous n'avez pas l'acces",
 *     }
 * },
 *     subresourceOperations={
 *          "api_get_profilsortie"={
 *              "method"="GET",
 *              "path"="/promo/{id}/profilsorties",
 *              "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous n'avez pas l'acces",
 *          },
 *         "get_apprenant"={
 *              "method"="GET",
 *              "path"="/promo/{idprof}/profilsorties/{idprom}",
 *          },
 * },
 *      itemOperations={
 *         "get"={
 *              "method"="GET",
 *              "path"="/profilsorties/{id}",
 *          },
 *           "put"={
 *              "method"="PUT",
 *              "path"="/profilsorties/{id}",
 *          },
 *      },
 * )
 */
class ProfilDeSortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"profilSortie:get"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archived;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profilDeSortie")
     * @Apisubresource()
     */
    private $apprenants;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
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
            $apprenant->setProfilDeSortie($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getProfilDeSortie() === $this) {
                $apprenant->setProfilDeSortie(null);
            }
        }

        return $this;
    }
}

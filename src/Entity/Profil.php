<?php

namespace App\Entity;

use App\Entity\User;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"get"}},
 *     routePrefix="/admin",
 *     attributes={"security"="is_granted('ROLE_ADMIN')",
 *         "security_message"="Vous n'avez pas l'acces"}, 
 * itemOperations={
 *         "get"={
 *              "method"="GET",
 *              "path"="/profils/{id}",
 *          },
 *         "put"={
 *              "method"="PUT",
 *              "path"="/profils/{id}",
 *          },
 *         "delete"={
 *              "method"="DELETE",
 *              "path"="/profils/{id}",
 *          },
 *      },
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archived"})
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("get")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="Champ libelle vide"
     * )

     * @Groups({"get","user:get"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profil")
     * @Apisubresource()
     */
    private $users;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archived = false;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfil($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfil() === $this) {
                $user->setProfil(null);
            }
        }

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
}

<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use App\Repository\ApprenantRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *  @ORM\Entity(repositoryClass=ApprenantRepository::class)
 *  @ApiResource(
 *     collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/apprenants",
 *          "normalization_context"={"groups":"apprenant:write"},
 *     },
 *     "post"={
 *              "method"="POST",
 *              "path"="/apprenants",
 *              "normalization_context"={"groups":"apprenant:write"},
 *     }
 *     },
 *      itemOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/apprenants/{id}",
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous n'avez pas l'acces"
 *     },
 *              "put"={
 *              "method"="PUT",
 *              "path"="/apprenants/{id}",
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous n'avez pas l'acces"
 *     },
 *     },
 *     )
 */
class Apprenant extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"apprenant:write"})
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity=ProfilDeSortie::class, inversedBy="apprenants")
     */
    private $profilDeSortie;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="apprenants")
     */
    private $promo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfilDeSortie(): ?ProfilDeSortie
    {
        return $this->profilDeSortie;
    }

    public function setProfilDeSortie(?ProfilDeSortie $profilDeSortie): self
    {
        $this->profilDeSortie = $profilDeSortie;

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }
}

<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\TagsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagsRepository::class)
 *  @ApiResource(
 *     denormalizationContext={"groups"={"tag_write"}},
 *     normalizationContext={"groups"={"tags_read"}},
 *     routePrefix="/admin",
 *     collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/tags",
 *             "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     }
 *     },
 *      itemOperations={
 *            "getItemp"={
 *              "method"="GET",
 *              "path"="/tags/{id}",
 *             "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     },
 *        "put"={
 *        "method"="PUT",
 *        "path"="/tags/{id}",
 *        "security"="is_granted('ROLE_ADMIN')",
 *        "security_message"="vous n'avez pas acces",
 *     }
 *     }
 * )
 */
class Tags
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(
     *     message="Champ libelle vide"
     * )
     * @Groups({"tags_read"})
     * @Groups({"tag_write"})
     * @Groups({"grptags_read"})
     * @Groups({"grptag_write"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tags_read"})
     * @Groups({"tag_write"})
     * @Groups({"grptags_read"})
     * @Groups({"grptag_write"})
     */
    private $descriptif;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"tags_read"})
     * @Groups({"tag_write"})
     * @Groups({"grptags_read"})
     * @Groups({"grptag_write"})
     */
    private $archived = false;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeTags::class, inversedBy="tags", cascade={"persist"})
     * @Groups({"tags_read"})
     * @Groups({"tag_write"})
     */
    private $groupetags;

    public function __construct()
    {
        $this->groupetags = new ArrayCollection();
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

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(?string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(?bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * @return Collection|GroupeTags[]
     */
    public function getGroupetags(): Collection
    {
        return $this->groupetags;
    }

    public function addGroupetag(GroupeTags $groupetag): self
    {
        if (!$this->groupetags->contains($groupetag)) {
            $this->groupetags[] = $groupetag;
        }

        return $this;
    }

    public function removeGroupetag(GroupeTags $groupetag): self
    {
        $this->groupetags->removeElement($groupetag);

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeTagsRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupeTagsRepository::class)
 *  @ApiResource(
 *   denormalizationContext={"groups"={"grptag_write"}},
 *     normalizationContext={"groups"={"grptags_read"}},
 *     routePrefix="/admin",
 *     collectionOperations={
 *          "get"={
 *              "method"="GET",
 *              "path"="/grptags",
 *             "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     },
 *        "post"={
 *              "method"="POST",
 *              "path"="/grptags",
 *             "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_ADMIN')",
 *             "security_message"="vous n'avez pas acces",
 *     }
 *     },
 *    itemOperations={
 *          "getItem"={
 *              "method"="GET",
 *              "path"="/grptags/{id}",
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas l'acces"
 *     },
 *     "getItem"={
 *              "method"="GET",
 *              "path"="/grptags/{id}/tags",
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas l'acces"
 *     },
 *      "put"={
 *              "method"="PUT",
 *              "path"="/grptags/{id}",
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas l'acces"
 *     }
 *     }
 *     )
 */
class GroupeTags
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
     * @Groups({"grptag_read"})
     * @Groups({"grptags_write"})
     * @Groups({"tags_read"})
     * @Groups({"tag_write"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archived=false;

    /**
     * @ORM\ManyToMany(targetEntity=Tags::class, mappedBy="groupetags", cascade={"persist"})
     * @Groups({"grptags_read"})
     * @Groups({"grptag_write"})
     * @Groups({"tags_read"})
     * @Groups({"tag_write"})
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
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

    public function setArchived(?bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * @return Collection|Tags[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addGroupetag($this);
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeGroupetag($this);
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\DeleteAction;
use App\Entity\Interfaces\CreatedAtSettableInterface;
use App\Entity\Interfaces\CreatedBySettableInterface;
use App\Entity\Interfaces\DeletedAtSettableInterface;
use App\Entity\Interfaces\UpdatedAtSettableInterface;
use App\Repository\CategoryRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(
            security: "is_granted('ROLE_ADMIN')",
        ),
        new Get(),
        new Put(security: "is_granted('ROLE_ADMIN')"),
        new Delete(
            controller: DeleteAction::class,
            security: "is_granted('ROLE_ADMIN')"
        )
    ],
    normalizationContext: ['groups' => ['category:read']],
    denormalizationContext: ['groups' => ['category:write']]
)]
class Category implements
    CreatedBySettableInterface,
    CreatedAtSettableInterface,
    UpdatedAtSettableInterface,
    DeletedAtSettableInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["category:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["category:read", "category:write", 'clinic:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["category:read", "category:write"])]
    private ?string $description = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["category:read"])]
    private ?User $createdBy = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $deletedAt = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Clinic::class)]
    private Collection $clinics;

    public function __construct()
    {
        $this->clinics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?UserInterface $user): self
    {
        $this->createdBy = $user;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection<int, Clinic>
     */
    public function getClinics(): Collection
    {
        return $this->clinics;
    }

    public function addClinic(Clinic $clinic): self
    {
        if (!$this->clinics->contains($clinic)) {
            $this->clinics->add($clinic);
            $clinic->setCategory($this);
        }

        return $this;
    }

    public function removeClinic(Clinic $clinic): self
    {
        if ($this->clinics->removeElement($clinic)) {
            // set the owning side to null (unless already changed)
            if ($clinic->getCategory() === $this) {
                $clinic->setCategory(null);
            }
        }

        return $this;
    }
}

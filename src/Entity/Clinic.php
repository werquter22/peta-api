<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
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
use App\Repository\ClinicRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClinicRepository::class)]
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
    normalizationContext: ['groups' => ['clinic:read']],
    denormalizationContext: ['groups' => ['clinic:write']]
)]
#[ApiFilter(SearchFilter::class, properties: ['category' => 'exact'])]
class Clinic implements
    CreatedBySettableInterface,
    CreatedAtSettableInterface,
    UpdatedAtSettableInterface,
    DeletedAtSettableInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['clinic:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['clinic:read', 'clinic:write', 'employee:read', 'service:read', 'order:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['clinic:read', 'clinic:write'])]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Groups(['clinic:read', 'clinic:write'])]
    private ?string $address = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['clinic:read', 'clinic:write'])]
    private ?string $description = null;

    #[ORM\ManyToOne]
    #[Groups(['clinic:read', 'clinic:write'])]
    private ?MediaObject $image = null;

    #[ORM\ManyToOne(inversedBy: 'clinics')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['clinic:read', 'clinic:write'])]
    private ?Category $category = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $createdBy = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $deletedAt = null;

    #[ORM\OneToMany(mappedBy: 'clinic', targetEntity: Employee::class)]
    private Collection $employees;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(?MediaObject $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
     * @return Collection<int, Employee>
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
            $employee->setClinic($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getClinic() === $this) {
                $employee->setClinic(null);
            }
        }

        return $this;
    }
}

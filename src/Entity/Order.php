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
use App\Controller\Order\AdmissionAction;
use App\Controller\Order\CreateOrderAction;
use App\Controller\Order\GetOrdersAction;
use App\Controller\Order\GetTodayOrdersAction;
use App\Entity\Interfaces\CreatedAtSettableInterface;
use App\Entity\Interfaces\CreatedBySettableInterface;
use App\Entity\Interfaces\DeletedAtSettableInterface;
use App\Entity\Interfaces\UpdatedAtSettableInterface;
use App\Repository\OrderRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    operations: [
        new GetCollection(
            controller: GetOrdersAction::class
        ),
        new GetCollection(
            uriTemplate: 'orders/today',
            controller: GetTodayOrdersAction::class
        ),
        new Post(
            controller: CreateOrderAction::class
        ),
        new Get(),
        new Put(
            controller: AdmissionAction::class,
            denormalizationContext: ['groups' => ['order:admission']],
            security: "is_granted('ROLE_ADMIN') || object.getEmployee().getUser() == user",
        ),
        new Delete(
            controller: DeleteAction::class,
            security: "is_granted('ROLE_ADMIN')"
        )
    ],
    normalizationContext: ['groups' => ['order:read']],
    denormalizationContext: ['groups' => ['order:write']]
)]
#[ApiFilter(SearchFilter::class, properties: ['employee' => 'exact', 'createdBy' => 'exact'])]
class Order implements
    CreatedBySettableInterface,
    CreatedAtSettableInterface,
    UpdatedAtSettableInterface,
    DeletedAtSettableInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:read', 'order:write'])]
    private ?Employee $employee = null;

    #[ORM\Column(length: 255)]
    #[Groups(['order:read'])]
    private ?string $orderNumber = null;

    #[ORM\Column]
    #[Groups(['order:read', 'order:admission'])]
    private ?int $status = 0;

    #[ORM\Column]
    #[Groups(['order:read', 'order:write'])]
    private ?bool $isHome = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:read'])]
    private ?User $createdBy = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['order:read'])]
    private ?DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $deletedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getIsHome(): ?bool
    {
        return $this->isHome;
    }

    public function setIsHome(bool $isHome): self
    {
        $this->isHome = $isHome;

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
}

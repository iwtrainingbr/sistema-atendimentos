<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @Entity
 */
class Scheduling
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private int $id;

    /**
     * @ManyToOne(targetEntity="Category")
     * @JoinColumn(referencedColumnName="id", name="category_id")
     */
    private Category $category;

    /**
     * @Column(type="datetime")
     */
    private \DateTime $datetime;

    /**
     * @Column(length=100)
     */
    private string $customer;

    /**
     * @Column()
     */
    private string $description;

    /**
     * @Column(type="datetime")
     */
    private \DateTime $createdAt;

    /**
     * @Column(length=20)
     */
    private string $status;

    public const STATUS_WAITING = 'Agendado';
    public const STATUS_CANCELED = 'Cancelado';
    public const STATUS_FINISHED = 'Finalizado';

    public function __construct()
    {
        $this->status = self::STATUS_WAITING;
        $this->createdAt = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getDatetime(): \DateTime
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTime $datetime): void
    {
        $this->datetime = $datetime;
    }

    public function getCustomer(): string
    {
        return $this->customer;
    }

    public function setCustomer(string $customer): void
    {
        $this->customer = $customer;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}

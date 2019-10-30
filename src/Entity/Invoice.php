<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 */
class Invoice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $invoiced_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $details;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $received_by;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $payed_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movement", mappedBy="invoices")
     */
    private $movements;

    public function __construct()
    {
        $this->movements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoicedAt(): ?\DateTimeInterface
    {
        return $this->invoiced_at;
    }

    public function setInvoicedAt(\DateTimeInterface $invoiced_at): self
    {
        $this->invoiced_at = $invoiced_at;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getReceivedBy(): ?string
    {
        return $this->received_by;
    }

    public function setReceivedBy(string $received_by): self
    {
        $this->received_by = $received_by;

        return $this;
    }

    public function getPayedAt(): ?\DateTimeInterface
    {
        return $this->payed_at;
    }

    public function setPayedAt(?\DateTimeInterface $payed_at): self
    {
        $this->payed_at = $payed_at;

        return $this;
    }

    /**
     * @return Collection|Movement[]
     */
    public function getMovements(): Collection
    {
        return $this->movements;
    }

    public function addMovement(Movement $movement): self
    {
        if (!$this->movements->contains($movement)) {
            $this->movements[] = $movement;
            $movement->addInvoice($this);
        }

        return $this;
    }

    public function removeMovement(Movement $movement): self
    {
        if ($this->movements->contains($movement)) {
            $this->movements->removeElement($movement);
            $movement->removeInvoice($this);
        }

        return $this;
    }

    public function __toString(){
        return $this->details;
    }
}

<?php

declare(strict_types=1);

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class RentalPayment
{
    /** @MongoDB\Id */
    private $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument=User::class)
     * @Assert\NotNull(message="El arrendatario es obligatorio.")
     */
    private $lessee;

    /**
     * @MongoDB\ReferenceOne(targetDocument=LeaseContract::class)
     * @Assert\NotNull(message="La propiedad es obligatoria.")
     */
    private $property;

    /**
     * @MongoDB\Field(type="date")
     * @Assert\NotBlank(message="La fecha de pago es obligatoria.")
     */
    private $paymentDate;

    /**
     * @MongoDB\Field(type="float")
     * @Assert\Positive(message="El monto debe ser positivo.")
     */
    private $amount;

    public function getId()
    {
        return $this->id;
    }

    public function getLessee()
    {
        return $this->lessee;
    }

    public function setLessee(User $lessee): self
    {
        $this->lessee = $lessee;

        return $this;
    }

    public function getProperty()
    {
        return $this->property;
    }

    public function setProperty(LeaseContract $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(\DateTime $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}

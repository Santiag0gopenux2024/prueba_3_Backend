<?php

declare(strict_types=1);

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class LeaseContract
{
    /** @MongoDB\Id */
    private $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="App\Document\User", storeAs="id")
     * @Assert\NotNull(message="El arrendatario es obligatorio.")
     */
    private User $lessee;

    /**
     * @MongoDB\Field(type="float")
     * @Assert\Positive(message="El valor del arriendo mensual debe ser positivo.")
     */
    private $monthlyRentAmount;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\Regex("/^[A-Z]{3}[0-9]{3}$/", message="El código de propiedad debe contener 3 letras y 3 números.")
     */
    private string $propertyCode;

    public function getId()
    {
        return $this->id;
    }

    public function getLessee(): User
    {
        return $this->lessee;
    }

    public function setLessee(User $lessee): self
    {
        $this->lessee = $lessee;

        return $this;
    }

    public function getMonthlyRentAmount()
    {
        return $this->monthlyRentAmount;
    }

    public function setMonthlyRentAmount(float $monthlyRentAmount): self
    {
        $this->monthlyRentAmount = $monthlyRentAmount;

        return $this;
    }

    public function getPropertyCode(): LeaseContract
    {
        return $this->propertyCode;
    }

    public function setPropertyCode(string $propertyCode): self
    {
        $this->propertyCode = $propertyCode;

        return $this;
    }
}

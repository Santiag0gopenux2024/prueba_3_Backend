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
    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\ReferenceOne(targetDocument="App\Document\User", storeAs="id")
     * @Assert\NotNull(message="El arrendatario es obligatorio.")
     */
    private $lessee;

    /**
     * @MongoDB\ReferenceOne(targetDocument="App\Document\LeaseContract", storeAs="id")
     * @Assert\NotNull(message="La propiedad es obligatoria.")
     */
    private $property;

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
}

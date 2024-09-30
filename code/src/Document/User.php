<?php

declare(strict_types=1);

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class User
{
    /** @MongoDB\Id */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank(message="El nombre no puede estar vacío.")
     */
    private $name;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank(message="El documento de identificación no puede estar vacío.")
     */
    private $identificationDocument;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank(message="El email no puede estar vacío.")
     * @Assert\Email(message="El email '{{ value }}' no es válido.")
     */
    private $email;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIdentificationDocument()
    {
        return $this->identificationDocument;
    }

    public function setIdentificationDocument(string $identificationDocument): self
    {
        $this->identificationDocument = $identificationDocument;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}

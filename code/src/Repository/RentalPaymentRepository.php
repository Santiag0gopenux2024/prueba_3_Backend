<?php

declare(strict_types=1);

namespace App\Repository;

use App\Document\RentalPayment;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class RentalPaymentRepository extends ServiceDocumentRepository
{
    public function findPaymentsByLessee(string $lesseeId)
    {
        return $this->findBy(['lessee' => $lesseeId]);
    }

    public function findPaymentsByProperty(string $propertyId)
    {
        return $this->findBy(['property' => $propertyId]);
    }
}
<?php

declare(strict_types=1);

namespace App\Repository;

use App\Document\LeaseContract;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class LeaseContractRepository extends ServiceDocumentRepository
{
    public function findByPropertyCode(string $propertyCode): ?LeaseContract
    {
        return $this->findOneBy(['propertyCode' => $propertyCode]);
    }
}
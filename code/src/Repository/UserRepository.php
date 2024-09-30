<?php

declare(strict_types=1);

namespace App\Repository;

use App\Document\User;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class UserRepository extends ServiceDocumentRepository
{
    public function findAllUsers()
    {
        return $this->findAll();
    }

    public function findUserById(string $id): ?User
    {
        return $this->find($id);
    }
}
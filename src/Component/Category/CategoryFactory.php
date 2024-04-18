<?php

declare(strict_types=1);

namespace App\Component\Category;

use App\Entity\Category;
use App\Entity\User;
use DateTime;

class CategoryFactory
{
    public function create(string $name, string $description, User $user): Category
    {
        return (new Category())
            ->setName($name)
            ->setDescription($description)
            ->setCreatedBy($user)
            ->setCreatedAt(new DateTime());
    }
}

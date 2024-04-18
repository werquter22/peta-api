<?php

declare(strict_types=1);

namespace App\Component\Clinic;

use App\Entity\Category;
use App\Entity\Clinic;
use App\Entity\MediaObject;
use App\Entity\User;
use DateTime;

class ClinicFactory
{
    public function create(
        string $name,
        string $phone,
        string $address,
        string $description,
        ?MediaObject $image,
        Category $category,
        User $user
    ): Clinic {
        return (new Clinic())
            ->setName($name)
            ->setPhone($phone)
            ->setAddress($address)
            ->setDescription($description)
            ->setImage($image)
            ->setCategory($category)
            ->setCreatedBy($user)
            ->setCreatedAt(new DateTime());
    }
}

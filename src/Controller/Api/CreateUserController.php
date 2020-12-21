<?php

namespace App\Controller\Api;

use App\Entity\Parents;
use Symfony\Component\Security\Core\Security;

class CreateUserController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke(Parents $data)
    {
        // dd($data);
        $data->setRoles("ROLE_PARENT");
        return $data;
    }
}
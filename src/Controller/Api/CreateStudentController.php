<?php

namespace App\Controller\Api;

use App\Entity\Parents;
use App\Entity\Students;
use Symfony\Component\Security\Core\Security;

class CreateStudentController
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke(Students $data)
    {
        // dump($data);
        // dd($this->security->getUser()->getParent());
        $data->addParent($this->security->getUser()->getParent());
        return $data;    
    }
}
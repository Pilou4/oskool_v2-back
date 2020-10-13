<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\Parents;
use App\Entity\Students;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class StudentVoter extends Voter
{
    const EDIT = "EDIT_STUDENT";


    protected function supports(string $attribute, $subject)
    {
        return
            $attribute === self::EDIT && 
            $subject instanceof Students;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        
        foreach ($subject->getParents() as $parent)
        {
            // dd($parent);
            return $parent;
        }

        if(!$user instanceof User || !$subject instanceof Students || empty($parent)) {
            return false;
        }
    //    dd($subject->getParents());
        return $parent->getId() === $user->getId();
    }
}
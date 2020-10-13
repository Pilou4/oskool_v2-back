<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\Parents;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ParentVoter extends Voter
{
    const EDIT = "EDIT_PARENT";

    protected function supports(string $attribute, $subject)
    {
        return
            $attribute === self::EDIT && 
            $subject instanceof Parents;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if(!$user instanceof User || !$subject instanceof Parents) {
            return false;
        }

        return $subject->getUser()->getId() === $user->getId();
    }
}
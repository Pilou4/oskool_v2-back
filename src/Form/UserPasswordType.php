<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Je crée un champ du formulaire qui devra contenir le mot de passe actuel de l'utilisateur
        // ce champ ne vient pas modifier l'objet manipulé par le formulaire (User) car l'option mapped=false
        // ce champ ne correspond  a aucune propriété de l'objet User
        // pour ajouter une contrainte de validation, on doit donc le faire directement dans le formulaire
        // Pour cela on rajoute l'option "Constraints" dans laquelle on ajoute toute les contraintes necessaires
        // la contrainte UserPassword permet de vérifier avec le composant security de Symfony que le contenu de ces champs correspond au mot de passe de l'utilisateur actuel

        $builder->add(
            'oldPassword',
            PasswordType::class,
            [
                "label" => "Mot de passe actuel",
                "mapped" => false,
                "constraints" => [
                    new UserPassword()
                ]
            ]
        );

        // Ce deuxième champ est non mappé lui aussi donc il ne va pas remplir une propriété de mon objet User
        // D'ailleurs ça ne servirait à rien car le mot de passe doit d'abort être encodé avant de remplacer celui de l'utilisateur
        $builder
            ->add(
                'password',
                RepeatedType::class,
                [
                    "mapped" => false,
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les deux mot de passe ne sont pas identiques',
                    'first_options' => ['label'=> 'Nouveau mot de passe'],
                    'second options' => ['label' => 'Repeter le nouveau de passe'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

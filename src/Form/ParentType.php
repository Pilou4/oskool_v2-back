<?php

namespace App\Form;

use App\Entity\Parents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ParentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'firstname',
            TextType::class,
            [
                'label' => 'prénom' 
            ]);
        $builder->add(
            'lastname',
            TextType::class,
            [
                'label' => 'nom' 
            ]);
        $builder->add(
            'adress',
            TextareaType::class,
            [
                'label' => 'adresse' 
            ]);
        $builder->add(
            'zipcode',
            IntegerType::class,
            [
                'label' => 'code postal' 
            ]);
        $builder->add(
            'city',
            TextType::class,
            [
                'label' => 'ville' 
            ]);
        $builder->add(
            'phone',
            IntegerType::class,
            [
                'label' => 'numérp de téléphone',
                "required" => false 
            ]);
        // $builder->add('students');
        // $builder->add('user');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Parents::class,
        ]);
    }
}

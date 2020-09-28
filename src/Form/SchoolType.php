<?php

namespace App\Form;

use App\Entity\Schools;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SchoolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            [
                "label"=> "nom"
            ]
        );
        
        $builder->add(
            'adress',
            TextareaType::class,
            [
                "label" => "adresse"
            ]
            
        );
        $builder->add(
            'zipcode',
            IntegerType::class,
            [
                "label" => "code postal"
            ]
            
        );
        $builder->add(
            'city',
            TextType::class,
            [
                'label' => 'ville' 
            ]
        );
        $builder->add(
            'students_number',
            IntegerType::class,
            [
                "label" => "nombre d'élèves",
                "required" => false
            ]
        );
        $builder->add(
            'agenda',
            TextareaType::class,
            [
                'label' => 'agenda',
                "required" => false,
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Schools::class,
        ]);
    }
}

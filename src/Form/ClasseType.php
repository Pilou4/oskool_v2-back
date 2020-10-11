<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Teachers;
use Doctrine\DBAL\Types\IntegerType as TypesIntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'level',
            TextType::class,
            [
                'label' => 'niveau' 
            ]);
        $builder->add(
            'number',
            IntegerType::class,
            [
                'label'=>'nombre d\'élève'
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

        $builder->add(
            "teachers",
            EntityType::class,
            [
                "class" => Teachers::class,
                "choice_label" => "lastname",
                "required" => false
            ]
        );
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Classes::class,
        ]);
    }
}

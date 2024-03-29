<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Teachers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class TeacherType extends AbstractType
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
            'mobile',
            IntegerType::class,
            [
                'label'=>'numéro de téléphone'
            ]
        );

        // $builder->add(
        //     'classes',
        //      EntityType::class,
        //     [
        //         'class' => Classes::class,
        //         'choice_label' => 'level',
        //         "multiple" => true,
        //         "expanded" => false,
        //         "required" => false
        //     ]
        // );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Teachers::class,
        ]);
    }
}

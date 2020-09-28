<?php

namespace App\Form;

use App\Entity\Students;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class StudentType extends AbstractType
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
            'birthday',
            DateType::class, 
            [
                "label" => "Date de naissance",
                "required" => false,
                "widget" => "single_text"
            ]);
        $builder->add(
            'age',
            IntegerType::class,
            [
                'label' => 'age' 
            ]
        );
        $builder->add(
            'level',
            TextType::class,
            [
                'label' => 'niveau',
                "required" => false
            ]);
        $builder->add(
            'hobbies',
            TextareaType::class,
            [
                'label' => 'hobbies',
                "required" => false
            ]);
        $builder->add(
            'health',
            TextareaType::class,
            [
                'label' => 'info sur la santé',
                "required" => false
            ]);
        $builder->add(
            'image_right',
            TextType::class,
            [
                'label' => 'autorisation de diffusé photo',
                "required" => false
            ]
        );
        // $builder->add('classes');
        // $builder->add('parents');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Students::class,
        ]);
    }
}

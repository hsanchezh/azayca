<?php

namespace App\Form;

use App\Entity\Conductor;
use App\Utils\Globales;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Twig\Environment;

class ConductorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $globales = Globales::getGlobales();
        $builder
            ->add('nombre', TextType::class, [])
            ->add('apellido1', TextType::class, [])
            ->add('apellido2', TextType::class, [])
            ->add('nif', TextType::class, [])
            ->add('fecha_alta', DateType::class, [
                //'widget' => 'single_text',
            ])
        ;
/*
        if ($options['include_fecha_baja']) {
            $builder->add('fecha_baja', null, [
                'widget' => 'single_text',
            ]);
        }*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conductor::class,
            'include_fecha_baja' => true,
        ]);
    }
}

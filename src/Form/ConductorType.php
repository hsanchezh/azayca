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
            ->add('nombre', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('apellido1', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('apellido2', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('nif', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('fecha_alta', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
        ;

        if ($options['include_fecha_baja']) {
            $builder->add('fecha_baja', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conductor::class,
            'include_fecha_baja' => false,
        ]);
    }
}

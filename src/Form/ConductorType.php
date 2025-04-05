<?php

namespace App\Form;

use App\Entity\Conductor;
use App\Utils\Globales;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

class ConductorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $globales = Globales::getGlobales();
        $builder
            ->add('nombre', null, ['label' => $globales['etiqueta_nombre'], 'attr' => ['placeholder' => 'nombre', 'style' => 'background-color: transparent; color: #000;']])
            ->add('apellido1')
            ->add('apellido2')
            ->add('nif')
            ->add('fecha_alta', null, [
                'widget' => 'single_text',
            ])
            ->add('fecha_baja', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conductor::class,
        ]);
    }
}

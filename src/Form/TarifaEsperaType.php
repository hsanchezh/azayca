<?php

namespace App\Form;

use App\Entity\TarifaEspera;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TarifaEsperaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('inicio_vigencia', null, [
                'widget' => 'single_text',
            ])
            ->add('fin_vigencia', null, [
                'widget' => 'single_text',
            ])
            ->add('precio_hora')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TarifaEspera::class,
        ]);
    }
}

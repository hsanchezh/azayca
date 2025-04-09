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
            ->add('precio_hora', null, [
                'attr' => ['class' => 'form-control'],
            ]);

        if ($options['include_inicio_vigencia']) {
            $builder->add('inicio_vigencia', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ]);
        }

        if ($options['include_fin_vigencia']) {
            $builder->add('fin_vigencia', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TarifaEspera::class,
            'include_inicio_vigencia' => true,
            'include_fin_vigencia' => false,
        ]);
    }
}

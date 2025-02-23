<?php

namespace App\Form;

use App\Entity\Conductor;
use App\Entity\Localidad;
use App\Entity\Paciente;
use App\Entity\TarifaEspera;
use App\Entity\TarifaKm;
use App\Entity\Viaje;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViajeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha', null, [
                'widget' => 'single_text',
            ])
            ->add('es_ida_vuelta')
            ->add('valoracion')
            ->add('comentarios')
            ->add('num_kilometros')
            ->add('importe_distancia')
            ->add('horas_espera')
            ->add('importe_espera')
            ->add('importe_total')
            ->add('id_paciente', EntityType::class, [
                'class' => Paciente::class,
                'choice_label' => 'id',
            ])
            ->add('id_conductor', EntityType::class, [
                'class' => Conductor::class,
                'choice_label' => 'id',
            ])
            ->add('id_tarifa_km', EntityType::class, [
                'class' => TarifaKm::class,
                'choice_label' => 'id',
            ])
            ->add('id_tarifa_espera', EntityType::class, [
                'class' => TarifaEspera::class,
                'choice_label' => 'id',
            ])
            ->add('id_localidad', EntityType::class, [
                'class' => Localidad::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Viaje::class,
        ]);
    }
}

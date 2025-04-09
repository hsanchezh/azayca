<?php

namespace App\Form;

use App\Entity\Conductor;
use App\Entity\Localidad;
use App\Entity\Paciente;
use App\Entity\TarifaEspera;
use App\Entity\TarifaKm;
use App\Entity\Valoracion;
use App\Entity\Viaje;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViajeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('es_ida_vuelta', null, [
                'attr' => ['class' => 'form-check-input'],
            ])
            ->add('valoracion', EnumType::class, [
                'class' => Valoracion::class,
                'attr' => ['class' => 'form-select'],
            ])
            ->add('comentarios', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control', 'rows'=>2],
            ])
            ->add('num_kilometros', null,[
                'attr'=>['inputmode' => 'numeric', 'class' => 'form-control'],
            ])
            ->add('horas_espera', null,[
                'attr'=>['inputmode' => 'numeric', 'class' => 'form-control'],
            ])
            ->add('id_paciente', EntityType::class, [
                'class' => Paciente::class,
                'choice_label' => 'nombreCompleto',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('id_conductor', EntityType::class, [
                'class' => Conductor::class,
                'choice_label' => 'nombreCompleto',
                'attr' => ['class' => 'form-select'],
            ])
        ;

        if ($options['include_tarifas']) {
            $builder->add('id_tarifa_espera', EntityType::class, [
                'class' => TarifaEspera::class,
                'choice_label' => 'nombreTarifa',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('id_tarifa_km', EntityType::class, [
                'class' => TarifaKm::class,
                'choice_label' => 'nombreTarifa',
                'attr' => ['class' => 'form-select'],
            ]);
        }

        if($options['include_id_localidad']) {
            $builder->add('id_localidad', EntityType::class, [
                'class' => Localidad::class,
                'choice_label' => 'nombre',
                'attr' => ['class' => 'form-select'],
            ]);
        }

        if($options['include_importes']) {
            $builder->add('importe_distancia', null, [
                    'attr' => ['class' => 'form-control'],
                ])
                ->add('importe_espera', null, [
                    'attr' => ['class' => 'form-control'],
                ])
                ->add('importe_total', null, [
                    'attr' => ['class' => 'form-control'],
                ]);
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Viaje::class,
            'include_tarifas' => true,
            'include_id_localidad' => false,
            'include_importes' => false,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Localidad;
use App\Entity\Paciente;
use App\Utils\Globales;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PacienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', null, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('apellido1', null, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('apellido2', null, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('email', null, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('telefono', null, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('telefono2', null, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('dni', null, [
                'attr' => ['class' => 'form-control'],
                'label' => Globales::getGlobales()['etiqueta_dni'],
            ])
            ->add('es_socio', CheckboxType::class, [
                'required' => false,
                'attr' => ['class' => 'form-check-label'],
            ])
            ->add('id_localidad', EntityType::class, [
                'class' => Localidad::class,
                'choice_label' => 'nombre',
                'attr' => ['class' => 'form-select'],
                'label' => Globales::getGlobales()['etiqueta_localidad_paciente'],
            ])
        ;

        if ($options['include_codigo']) {
            $builder->add('codigo', null, [
                'attr' => ['class' => 'form-control'],
            ]);
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paciente::class,
            'include_codigo' => true,
        ]);
    }
}

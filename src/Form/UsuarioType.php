<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $esAdmin=($options)?$options['checkbox_es_admin']:'false';

        $builder
            ->add('login', null, [
                'attr' => ['class' => 'form-control'],
            ]);

        if($options['include_password']) {
            $builder
                ->add('password', PasswordType::class, [
                    'always_empty' => true,
                    'attr' => ['form-control'],
                ]);
        }

        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('es_admin', null, [
                'attr' => ['class' => 'form-check-label'],
                'value' => $esAdmin,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
            'include_password' => true,
            'checkbox_es_admin' => 'false',
        ]);
    }
}

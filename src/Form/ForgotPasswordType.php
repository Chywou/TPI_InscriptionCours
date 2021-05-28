<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class ForgotPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', Null,  [
                'label' => 'Mail',
                'constraints' => [
                new Email(['message' => 'Veuillez entrer une adresse mail.']),
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }
}

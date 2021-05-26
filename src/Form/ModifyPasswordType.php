<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Regex;

class ModifyPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', RepeatedType::class, array(
                'type'              => PasswordType::class,
                'mapped'            => false,
                'first_options'     => array('label' => 'Nouveau mot de passe'),
                'second_options'    => array('label' => 'Confirmer le mot de passe'),
                'invalid_message' => 'Les 2 mots de passe ne sont pas identiques',
                'constraints' => [
                    new Length(['min' => 12, 'max' => 100, 'minMessage' => 'Le mot de passe doit faire au minimum {{ limit }} caractères.', 'maxMessage' => 'Le mot de passe doit faire au maximum {{ limit }} caractères.']),
                    new NotCompromisedPassword(['message' => 'Ce mot de passe est trop générique.']),
                    new Regex(['pattern' => '/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W+_])/', 'message'=> 'Le mot de passe doit contenir au moins un chiffre, une lettre minuscule, une lettre majuscule et un caractère spécial.'])
                ],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

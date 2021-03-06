<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;


class ModifyAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword',  PasswordType::class, [
                'label'             => 'Mot de passe actuel',
                'mapped'            => false,
                'constraints'       => [
                    new UserPassword(['message' => 'Veuillez entrer votre mot de passe actuel.'])
                ]
            ])
            ->add('email', Null,  ['label' => 'Email'])
            ->add('firstName', Null,  ['label' => 'Prénom'])
            ->add('lastName', Null,  ['label' => 'Nom'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

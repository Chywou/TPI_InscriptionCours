<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Lesson;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddLessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateLesson', Null, ['label' => 'Date du cours', 'widget' => 'single_text'])
            ->add('startHour', Null,  ['label' => 'Heure', 'widget' => 'single_text'])
            ->add('endHour', Null,  ['label' => 'à', 'widget' => 'single_text'])
            ->add('peopleNumber', Null,  ['label' => 'Nombre de participants'])
            ->add('category', EntityType::class, ['label' => 'Catégorie', 'class' =>'App:Category', 'choice_label' => 'name'])
            ->add('user', EntityType::class, ['label' => 'Résponsable', 'class' =>'App:User', 'choice_label' =>  function (User $user) {
                return $user->getFirstName() . ' ' . $user->getLastName();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}

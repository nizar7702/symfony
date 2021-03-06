<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, ['required' => true,
            'multiple' => false,
            'expanded' => false,
            'choices' => [
             "Admin" => 'ROLE_ADMIN',
             "Enseignant" => 'ROLE_ENSEIGNENT',
             "Etudiant" => 'ROLE_ETUDIANT',
            ],
            ])
            ->add('password')
            ->add('FullName')
        ;
        $builder->get('roles')
                ->addModelTransformer(new CallbackTransformer(
                    function($rolesArray){
                        return count($rolesArray) ? $rolesArray[0] : null;
                    },
                    function ($rolesString) {
                        return [$rolesString];
                    }
                ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

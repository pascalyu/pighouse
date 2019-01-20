<?php

namespace App\Form;

use App\Entity\Pig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Pig1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudoName')
            ->add('email')
            ->add('password')
            ->add('createdAt')
            ->add('lastUpdatedAt')
            ->add('deletedAt')
            ->add('username')
            ->add('houses')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pig::class,
        ]);
    }
}

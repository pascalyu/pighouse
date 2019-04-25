<?php

namespace App\Form;

use App\Entity\House;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class JoinHouseType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add("house_unique_id", TextType::class, array(
                    "label" => "House Id",
                    'constraints' => new Length(['min' => 8,'max'=>8])))
                ->add('password')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => House::class,
        ]);
    }

}

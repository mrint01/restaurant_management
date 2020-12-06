<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UsrType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('lastname')
            ->add('email')
            ->add('username')
            ->add('password')
            ->add('numtel',TextType::class, array('label' => 'Numéro de tel '))
            ->add('addresse')
            ->add('roles' , ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'Rôles',
                'choices' =>[

                    'Utilisateur' => 'ROLE_USER',
                    'Gerant' => 'ROLE_GERANT',
                    'Directeur de Stock' => 'ROLE_stock',
                    'Directeur de Vente' => 'ROLE_Vente',
                    'Livreur' => 'ROLE_Delivery'



                ]
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usr'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_usr';
    }


}

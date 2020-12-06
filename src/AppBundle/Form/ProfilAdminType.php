<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProfilAdminType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('username',TextType::class, array('label' => "Nom D'utilisateur"))
            ->add('name',TextType::class, array('label' => 'Prénom '))
            ->add('lastname',TextType::class, array('label' => 'Nom '))
            ->add('email')
            ->add('numtel',TextType::class, array('label' => 'Numéro de tel '))
            ->add('addresse');



    }
}

<?php

namespace RuslanKovalov\ChatBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('users', 'entity', [
                'class' => 'RuslanKovalov\ChatBundle\Entity\User',
                'multiple' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'RuslanKovalov\ChatBundle\Entity\Chat',
        ]);
    }

    public function getName()
    {
        return 'chat';
    }
}
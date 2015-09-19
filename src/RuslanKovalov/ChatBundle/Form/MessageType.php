<?php

namespace RuslanKovalov\ChatBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', 'text')
            ->add('chat', 'entity', ['class' => 'RuslanKovalov\ChatBundle\Entity\Chat'])
            ->add('sender', 'entity', ['class' => 'RuslanKovalov\ChatBundle\Entity\User'])
            ->add('status', 'text')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'RuslanKovalov\ChatBundle\Entity\Message',
        ]);
    }

    public function getName()
    {
        return 'message';
    }
}
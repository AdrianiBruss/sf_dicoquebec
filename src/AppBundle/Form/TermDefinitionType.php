<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\True;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TermDefinitionType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description','text', array('label' => 'Définition'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Definition'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_term';
    }
}

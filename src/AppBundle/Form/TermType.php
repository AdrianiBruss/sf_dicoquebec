<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\True;
class TermType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('category')
            ->add('variation')
            ->add('pronunciation')
            ->add('nature')
            ->add('genre')
            ->add('number')
            ->add('origin')
            ->add('recaptcha', 'ewz_recaptcha',array(
                'mapped'      => false,
                'constraints' => array(
                    new True()
                ),
                'error_bubbling'=>true
            ))
            ->add('Add New', 'submit', array('label' => 'Ajouter'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Term'
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

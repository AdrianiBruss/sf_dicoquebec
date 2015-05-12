<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\True;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class TermUpdateType extends AbstractType
{
    private $session;
    public function __construct($session){
        $this->session=$session;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category')
            ->add('variation')
            ->add('pronunciation')
            ->add('nature')
            ->add('genre')
            ->add('number')

            ->add('origin')

            ->add('Update', 'submit', array('label'=>'Modifier'))
            ->add('Delete', 'submit', array('label'=>'supprimer'));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
            if(!$this->session->get('email')){
                $form = $event->getForm();
                $form->add('email','email',array(
                    'mapped'=>false,
                    'required'    => true
                ))
                ->add('recaptcha', 'ewz_recaptcha',array(
                    'mapped'      => false,
                    'constraints' => array(
                        new True()
                    ),
                    'error_bubbling'=>true
                ));
            }
        });
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
        return 'appbundle_update_term';
    }
}

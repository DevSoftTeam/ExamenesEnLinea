<?php

namespace EvaluationsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleTest')
            ->add('matter')
            ->add('institution')
            ->add('hourInit')
            ->add('hourEnd')
            ->add('date')
            /*->add('hourInit', 'date')
            ->add('hourEnd', 'date')
            ->add('date', 'date')*/
            ->add('scoreTest')
            ->add('totalPercentage')
            ->add('testPassword')
            ->add('idUser')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EvaluationsBundle\Entity\Test'
        ));
    }
}

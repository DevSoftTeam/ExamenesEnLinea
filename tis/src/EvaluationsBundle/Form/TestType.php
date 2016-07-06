<?php

namespace EvaluationsBundle\Form;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
            ->add('title')
            ->add('matter')
            ->add('institution')
            ->add('startTime', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'required' => false,
                'attr' => ['class' => 'datepicker'],
            ))
            ->add('endTime', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => true,
                'required' => false,
                'attr' => ['class' => 'datepicker'],
            ))
            ->add('startEnrollment', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => true,
                'required' => false,
                'attr' => ['class' => 'datepicker'],
            ))
            ->add('endEnrollment', DateTimeType::class, array(
                'widget' => 'single_text',
                'html5' => true,
                'required' => false,
                'attr' => ['class' => 'datepicker'],
            ))
            ->add('score')
            ->add('percentage')
           // ->add('idUser')
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

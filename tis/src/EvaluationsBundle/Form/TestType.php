<?php

namespace EvaluationsBundle\Form;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
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
            ->add('startTime', TimeType::class, array(
                'widget' => 'single_text',
//                'attr' => ['type' => 'time'],
//                'format' => 'HH:ii',
                'label' => ' ',
                'required' =>false
            ))
            ->add('startDate',DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'datepicker'],
                'required' => false,
            ))
            ->add('endTime', TimeType::class, array(
                'widget' => 'single_text',
//                'attr' => ['type' => 'time'],
                'label' => ' ',
                'required' =>false
            ))
            ->add('endDate',DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'datepicker'],
                'required' => false,
            ))
            ->add('startTimeEnrollment', TimeType::class, array(
                'widget' => 'single_text',
//                'attr' => ['type' => 'time'],
                'label' => ' ',
                'required' =>false
            ))
            ->add('startDateEnrollment',DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'datepicker'],
                'required' => false,
            ))
            ->add('endTimeEnrollment', TimeType::class, array(
                'widget' => 'single_text',
//                'attr' => ['type' => 'time'],
                'label' => ' ',
                'required' =>false
            ))
            ->add('endDateEnrollment',DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'datepicker'],
                'required' =>false
            ))
            ->add('score')
            ->add('percentage')
//            ->add('idUser')
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

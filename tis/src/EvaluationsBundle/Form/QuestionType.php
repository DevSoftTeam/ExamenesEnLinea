<?php

namespace EvaluationsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class QuestionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statementQuestion')
            ->add('pathImageQuestion')
            ->add('pathFileQuestion')
           // ->add('idType')
           // ->add('idArea')
            ->add('image', FileType::class,array(
                "label" => "Imagen:",
                "attr" =>array("class" => "form-control")
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EvaluationsBundle\Entity\Question'
        ));
    }
}

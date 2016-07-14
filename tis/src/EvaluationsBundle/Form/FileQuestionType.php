<?php

namespace EvaluationsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FileQuestionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statementQuestion')
            ->add('image', FileType::class,array(
                "label" => "Imagen:",
                "attr" =>array("class" => "form-control"),
                "required" => false
            ))
            ->add('file', FileType::class,array(
                "label" => "File:",
                "attr" =>array("class" => "form-control"),
                "required" => true
            ))
            ->add('pathImageQuestion', HiddenType::class,array(
                "required" => false
            ))
            ->add('pathFileQuestion', HiddenType::class,array(
                "required" => false
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

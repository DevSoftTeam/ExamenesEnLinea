<?php

namespace EvaluationsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
            ->add('area', EntityType::class, array(
                    'class' => 'EvaluationsBundle:Area',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.idArea', 'DESC');
                    },
                    'choice_label' => 'nameArea',
                    'choice_value' => 'idArea',
                    'required' => true,
            ))
            ->add('image', FileType::class,array(
                "label" => "Imagen:",
                "attr" =>array("class" => "form-control"),
                "required" => false
            ))
        ;
    }

    public function buildFormFileQuestion(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('statementQuestion')
            ->add('idType', HiddenType::class)
            ->add('area', EntityType::class, array(
                    'class' => 'EvaluationsBundle:Area',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.idArea', 'DESC');
                    },
                    'choice_label' => 'nameArea',
                    'choice_value' => 'idArea',
                    'required' => true,
            ))
            ->add('image', FileType::class,array(
                "label" => "Imagen:",
                "attr" =>array("class" => "form-control"),
                "required" => false
            ))
            ->add('pathFileQuestion', FileType::class,array(
                "label" => "archivo:",
                "attr" =>array("class" => "form-control"),
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

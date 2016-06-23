<?php

namespace EvaluationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question", uniqueConstraints={@ORM\UniqueConstraint(name="question_pk", columns={"id_question"})}, indexes={@ORM\Index(name="tiene_12_fk", columns={"id_area"}), @ORM\Index(name="pertenece_fk", columns={"id_type"})})
 * @ORM\Entity
 */
class Question
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_question", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="question_id_question_seq", allocationSize=1, initialValue=1)
     */
    private $idQuestion;

    /**
     * @var string
     *
     * @ORM\Column(name="statement_question", type="text", nullable=false)
     */
    private $statementQuestion;

    /**
     * @var string
     *
     * @ORM\Column(name="path_image_question", type="string", length=256, nullable=true)
     */
    private $pathImageQuestion;

    /**
     * @var string
     *
     * @ORM\Column(name="path_file_question", type="string", length=256, nullable=true)
     */
    private $pathFileQuestion;

    /**
     * @var \TypeCuestion
     *
     * @ORM\ManyToOne(targetEntity="TypeCuestion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type", referencedColumnName="id_type")
     * })
     */
    private $idType;

    /**
     * @var \Area
     *
     * @ORM\ManyToOne(targetEntity="Area")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_area", referencedColumnName="id_area")
     * })
     */
    private $idArea;


}


<?php

namespace EvaluationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Association
 *
 * @ORM\Table(name="association", uniqueConstraints={@ORM\UniqueConstraint(name="association_pk", columns={"id_association"})}, indexes={@ORM\Index(name="relationship_14_fk", columns={"id_answer_element"}), @ORM\Index(name="relationship_13_fk", columns={"id_question"})})
 * @ORM\Entity
 */
class Association
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_association", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="association_id_association_seq", allocationSize=1, initialValue=1)
     */
    private $idAssociation;

    /**
     * @var \Question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_question", referencedColumnName="id_question")
     * })
     */
    private $idQuestion;

    /**
     * @var \AnswerElement
     *
     * @ORM\ManyToOne(targetEntity="AnswerElement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_answer_element", referencedColumnName="id_answer_element")
     * })
     */
    private $idAnswerElement;


}


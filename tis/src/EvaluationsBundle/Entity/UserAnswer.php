<?php

namespace EvaluationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAnswer
 *
 * @ORM\Table(name="user_answer", uniqueConstraints={@ORM\UniqueConstraint(name="user_answer_pk", columns={"id_user_answer"})}, indexes={@ORM\Index(name="respondio_fk", columns={"id_user", "id_test"}), @ORM\Index(name="relationship_12_fk", columns={"id_question"})})
 * @ORM\Entity
 */
class UserAnswer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_user_answer", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_answer_id_user_answer_seq", allocationSize=1, initialValue=1)
     */
    private $idUserAnswer;

    /**
     * @var string
     *
     * @ORM\Column(name="response", type="text", nullable=true)
     */
    private $response;

    /**
     * @var string
     *
     * @ORM\Column(name="order_answer", type="string", length=24, nullable=true)
     */
    private $orderAnswer;

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
     * @var \TestTaken
     *
     * @ORM\ManyToOne(targetEntity="TestTaken")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user"),
     *   @ORM\JoinColumn(name="id_test", referencedColumnName="id_test")
     * })
     */
    private $idTestTaken;


}


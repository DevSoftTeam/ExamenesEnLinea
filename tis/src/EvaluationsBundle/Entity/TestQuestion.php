<?php

namespace EvaluationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TestQuestion
 *
 * @ORM\Table(name="test_question", uniqueConstraints={@ORM\UniqueConstraint(name="test_cuestion_pk", columns={"id_question"})}, indexes={@ORM\Index(name="tiene_1_fk", columns={"id_test"})})
 * @ORM\Entity
 */
class TestQuestion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="percent", type="integer", nullable=false)
     */
    private $percent;

    /**
     * @var \Question
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_question", referencedColumnName="id_question")
     * })
     */
    private $idQuestion;

    /**
     * @var \Test
     *
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_test", referencedColumnName="id_test")
     * })
     */
    private $idTest;


}

<?php

namespace EvaluationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TestQuestion
 *
 * @ORM\Table(name="test_question", uniqueConstraints={@ORM\UniqueConstraint(name="test_cuestion_pk",columns={"id_question","id_test"})}, indexes={@ORM\Index(name="tiene_1_fk", columns={"id_test"})})
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
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_test", referencedColumnName="id_test")
     * })
     */
    private $idTest;


    public function setPercent($percent){
        $this->percent = $percent;
    }

    public function setIdQuestion($question){
        $this->idQuestion = $question;
    }

    public function setIdTest($test){
        $this->idTest = $test;
    }    

    public function __call($name, $arguments)
    {
        echo "Llamando al método de objeto '$name' "
            . implode(', ', $arguments). "\n";
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return $this;
    }

}


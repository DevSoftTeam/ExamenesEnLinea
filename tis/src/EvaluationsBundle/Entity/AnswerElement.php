<?php

namespace EvaluationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnswerElement
 *
 * @ORM\Table(name="answer_element", uniqueConstraints={@ORM\UniqueConstraint(name="answer_element_pk", columns={"id_answer_element"})}, indexes={@ORM\Index(name="puede_tener_fk", columns={"id_question"})})
 * @ORM\Entity
 */
class AnswerElement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_answer_element", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="answer_element_id_answer_element_seq", allocationSize=1, initialValue=1)
     */
    private $idAnswerElement;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="order_var", type="string", length=24, nullable=false)
     */
    private $orderVar;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_correct", type="boolean", nullable=false)
     */
    private $isCorrect;

    /**
     * @var \Question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_question", referencedColumnName="id_question", nullable=false)
     * })
     */

    public function getIdQuestion()
    {
        return $this->idQuestion;
    }
    public function setIdQuestion($idQuestion)
    {
        $this->idQuestion=$idQuestion;
        return $this->idQuestion;
    }
    private $idQuestion;

    public function getId()
    {
        return $this->id;
    }

    public function getIdAnswerElement($idAnswerElement)
    {
        return $this->idAnswerElement;
    }

    public function getContent()
    {
        return $this->content;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    public function getOrderVar()
    {
        return $this->orderVar;
    }
    public function setOrderVar($orderVar)
    {
        $this->orderVar = $orderVar;
        return $this;
    }

    public function getIsCorrect(){
        return $this->isCorrect;
    }
    public function setIsCorrect($isCorrect){
        $this->isCorrect = $isCorrect;
        return $this;
    }
    
    

    public function setIdQuestion($idQuestion){
        $this->idQuestion = $idQuestion;
        return $this;
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

    public function __call($name, $arguments){
        echo "Llamando al método de objeto '$name' "
            . implode(', ', $arguments). "\n";
    }

}


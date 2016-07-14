<?php

namespace EvaluationsBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @ORM\Column(name="id_question", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="question_id_question_seq", allocationSize=1, initialValue=1)
     */
    private $idQuestion;
    /**
     * @var string
     * @ORM\Column(name="statement_question", type="text", nullable=false)
     * @Assert\Length(min=5) 
     * @Assert\NotBlank()
     */
    private $statementQuestion;
    /**
     * @var string
     * @ORM\Column(name="path_image_question", type="string", length=256, nullable=true)
     */
    private $pathImageQuestion;
    /**
     * @var string
     * @ORM\Column(name="path_file_question", type="string", length=256, nullable=true)
     */
    private $pathFileQuestion;
    /**
     * @var \TypeQuestion
     * @ORM\ManyToOne(targetEntity="TypeQuestion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type", referencedColumnName="id_type")
     * })
     */
    private $idType;
    /**
     * @var \Area
     * @ORM\ManyToOne(targetEntity="Area")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_area", referencedColumnName="id_area", nullable=false)
     * })
     */
    private $idArea;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->idQuestion;
    }
    public function getIdQuestion()
    {
        return $this->idQuestion;
    }

    public function getURL()
    {
        $idT = $this->idType->idType;
        $id = $this->idQuestion;
        $links = array(1=>'showOQ',2 =>'showOrQ',3=> 'show',4=>'showTFQ',5=>'showUAQ',6=>'showMQ',7=>'showMQ');
        $link = "/question/".$id."/".$links[$idT];
        return $link;
    }

    public function setStatementQuestion($statementQuestion)
    {
        $this->statementQuestion = $statementQuestion;
        return $this;
    }
    public function getStatementQuestion()
    {
        return $this->statementQuestion;
    }
    public function setPathImageQuestion($pathImageQuestion)
    {
        $this->pathImageQuestion = $pathImageQuestion;
        return $this;
    }
    public function getPathImageQuestion()
    {
        return $this->pathImageQuestion;
    }
    public function setPathFileQuestion($pathFileQuestion)
    {
        $this->pathFileQuestion = $pathFileQuestion;
        return $this;
    }
    public function getPathFileQuestion()
    {
        return $this->pathFileQuestion;
    }
    public function setIdType($idType)
    {
        $this->idType = $idType;
        return $this;
    }
    public function getIdType()
    {
        return $this->idType;
    }
    public function setIdArea($idArea)
    {
        $this->idArea = $idArea;
        return $this;
    }
    public function getIdArea()
    {
        return $this->idArea;
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


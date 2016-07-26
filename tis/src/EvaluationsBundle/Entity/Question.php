<?php

namespace EvaluationsBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use EvaluationsBundle\Entity\AnswerElement;
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
     *   @ORM\JoinColumn(name="id_type", referencedColumnName="id_type", nullable=false)
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
     * @var \UserSystem
     *
     * @ORM\ManyToOne(targetEntity="UserSystem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user", nullable=true)
     * })
     */
    private $idUser;

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

    public function getQuestionView($elements){
        $idT = $this->idType->idType;
        $html = "";
        switch ($idT) {
            case 1:
                $html = $this->getViewStatement();
                break;
            case 2:
                $html = $this->getViewOrdenamiento($elements);
                    break;
            case 3:
                $html = $this->getViewFileQuestion();
                break;
            case 4:
                $html = $this->getTrueFalse($elements);
                break;
            case 6:
                $html = $this->getViewMultipleQuestion($elements);
                break;
            case 7:
                $html = $this->getViewEmparejamiento($elements);
                    break;

            default:
                $html = $this->getViewStatement();
                break;
        }
        return $html;
    }

    public function getViewStatement(){
        $html = "";
        if ($this->pathImageQuestion != null) {
            $html = "<div class=\"row\">
                    <div class=\"col s12\">
                        <label class=\"teal-text darken-4\"><h6>Enunciado :</h6></label>
                        <div><pre>".$this->statementQuestion."</pre></div>
                    </div><br><br><br>
                    <div class=\"col s12 alight center\">
                        {% if question.pathImageQuestion != null %}
                        <img height=\"40%\" width=\"40%\" src=\"{{ asset('uploads/images/')}}{{question.pathImageQuestion}}\">
                        {% endif %}
                    </div>";
        }
        else{
            $html = "<div class=\"row\">
                    <div class=\"col s12\">
                        <label class=\"teal-text darken-4\"><h6>Enunciado :</h6></label>
                    <pre>".$this->statementQuestion."</pre>
                    </div>
                </div>";
        }
        return $html;
    }

    public function getViewEmparejamiento($elements){
        $html = $this->getViewStatement()."<div class=\"row\">";  
        foreach ($elements as $value) {
            $el = "
                <div class=\"col s12\">
                    <p>".$value->content."</p>
                </div>";
            $html = $html.$el;
        }
        return $html."</div>";
    }

    public function getViewOrdenamiento($elements){
        $html = $this->getViewStatement()."<div class=\"row\">";  
        foreach ($elements as $value) {
            $el = "
                <div class=\"col s12\">
                    <p>".$value->content."</p>
                </div>";
            $html = $html.$el;
        }
        return $html."</div>";
    }

    public function getViewMultipleQuestion($elements){
        $html = $this->getViewStatement()."<div class=\"row\">";  
        foreach ($elements as $value) {
            $el = "
                <div class=\"col s12\">
                    <p>
                      <input type=\"checkbox\" class=\"filled-in\"/>
                      <label>".$value->content."</label>
                    </p>
                </div>";
            $html = $html.$el;
        }
        return $html."</div>";
    }

    public function getViewFileQuestion(){
        $html = "<div class=\"row\">
                    <div class=\"col s12\">
                        <label class=\"teal-text darken-4\"><h6>Enunciado :</h6></label>
                    <pre>".$this->statementQuestion."</pre>
                    </div>
                </div>
                <div class=\"col s12\">
                <label class=\"teal-text darken-4\"><h6>Archivo :</h6></label>
                <a class=\"waves-effect waves-light btn\" href=\"/uploads/".$this->pathFileQuestion."\" download>Download</a>
            </div>"
        ;
        return $html;

    }

    public function getTrueFalse($elements){
        $html = $this->getViewStatement();
 
        $answerEl = " <div id=\"TrueFalse\">
            <input type=\"radio\" id=\"t\" disabled>
              <label for=\"t\">Verdadero</label>
 
              <input type=\"radio\" id=\"f\" disabled>
              <label for=\"f\">Falso</label>
        </div>";
        return $html.$answerEl;
    }

    public function getURL()
    {
        $idT = $this->idType->idType;
        $id = $this->idQuestion;
        $links = array(1=>'showOQ',2 =>'showOrQ',3=> 'show',4=>'showTFQ',5=>'showUAQ',6=>'showMQ',7=>'showMMQ');
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
    /**
     * @return \UserSystem
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param \UserSystem $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
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


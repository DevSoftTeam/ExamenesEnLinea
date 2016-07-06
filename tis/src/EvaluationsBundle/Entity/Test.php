<?php

namespace EvaluationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="EvaluationsBundle\Repository\TestRepository")
 */
class Test
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_test", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idTest;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="matter", type="string", length=255)
     */
    private $matter;

    /**
     * @var string
     *
     * @ORM\Column(name="institution", type="string", length=255, nullable=true)
     */
    private $institution;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetime", nullable=true)
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetime", nullable=true)
     */
    private $endTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_enrollment", type="datetime", nullable=true)
     */
    private $startEnrollment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_enrollment", type="datetime", nullable=true)
     */
    private $endEnrollment;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;

    /**
     * @var int
     *
     * @ORM\Column(name="percentage", type="integer", nullable=true)
     */
    private $percentage;

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
        return $this->idTest;
    }

    /**
     * @return int
     */
    public function getIdTest()
    {
        return $this->idTest;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Test
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set matter
     *
     * @param string $matter
     *
     * @return Test
     */
    public function setMatter($matter)
    {
        $this->matter = $matter;

        return $this;
    }

    /**
     * Get matter
     *
     * @return string
     */
    public function getMatter()
    {
        return $this->matter;
    }

    /**
     * Set institution
     *
     * @param string $institution
     *
     * @return Test
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;

        return $this;
    }

    /**
     * Get institution
     *
     * @return string
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return Test
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getMonth()
    {
        return $this->startTime.month;
    }
    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return Test
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set startEnrollment
     *
     * @param \DateTime $startEnrollment
     *
     * @return Test
     */
    public function setStartEnrollment($startEnrollment)
    {
        $this->startEnrollment = $startEnrollment;

        return $this;
    }

    /**
     * Get startEnrollment
     *
     * @return \DateTime
     */
    public function getStartEnrollment()
    {
        return $this->startEnrollment;
    }

    /**
     * Set endEnrollment
     *
     * @param \DateTime $endEnrollment
     *
     * @return Test
     */
    public function setEndEnrollment($endEnrollment)
    {
        $this->endEnrollment = $endEnrollment;

        return $this;
    }

    /**
     * Get endEnrollment
     *
     * @return \DateTime
     */
    public function getEndEnrollment()
    {
        return $this->endEnrollment;
    }

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return Test
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set percentage
     *
     * @param integer $percentage
     *
     * @return Test
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return int
     */
    public function getPercentage()
    {
        return $this->percentage;
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
    public function setIdUser()//$idUser)
    {
        $this->idUser = 1;//$idUser;
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


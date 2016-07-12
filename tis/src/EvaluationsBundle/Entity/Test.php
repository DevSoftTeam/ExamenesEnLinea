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
     * @var \Time
     *
     * @ORM\Column(name="start_time", type="time", nullable=true)
     */
    private $startTime;

    /**
     * @var \Time
     *
     * @ORM\Column(name="end_time", type="time", nullable=true)
     */
    private $endTime;

    /**
     * @var \Date
     *
     * @ORM\Column(name="start_date", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var \Date
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;
    /**
     * @var \Time
     *
     * @ORM\Column(name="start_tenrollment", type="time", nullable=true)
     */
    private $startTimeEnrollment;

    /**
     * @var \Time
     *
     * @ORM\Column(name="end_tenrollment", type="time", nullable=true)
     */
    private $endTimeEnrollment;

    /**
     * @var \Date
     *
     * @ORM\Column(name="start_denrollment", type="date", nullable=true)
     */
    private $startDateEnrollment;

    /**
     * @var \Date
     *
     * @ORM\Column(name="end_denrollment", type="date", nullable=true)
     */
    private $endDateEnrollment;

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
     * @var boolean
     *
     * @ORM\Column(name="available", type="boolean", nullable=true)
     */
    private $available;


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
    /**
     * @return \Date
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return \Time
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return \Date
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return \Time
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @return \Date
     */
    public function getStartDateEnrollment()
    {
        return $this->startDateEnrollment;
    }

    /**
     * @return \Time
     */
    public function getStartTimeEnrollment()
    {
        return $this->startTimeEnrollment;
    }

    /**
     * @return \Date
     */
    public function getEndDateEnrollment()
    {
        return $this->endDateEnrollment;
    }

    /**
     * @return \Time
     */
    public function getEndTimeEnrollment()
    {
        return $this->endTimeEnrollment;
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
     * Set available
     *
     * @param boolean $available
     *
     * @return PruebaD
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return bool
     */
    public function getAvailable()
    {
        return $this->available;
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


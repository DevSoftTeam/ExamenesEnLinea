<?php

namespace EvaluationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table(name="test", uniqueConstraints={@ORM\UniqueConstraint(name="test_pk", columns={"id_test"})}, indexes={@ORM\Index(name="crear_fk", columns={"id_user"})})
 * @ORM\Entity
 */
class Test
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_test", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="test_id_test_seq", allocationSize=1, initialValue=1)
     */
    private $idTest;

    /**
     * @var string
     *
     * @ORM\Column(name="title_test", type="string", length=200, nullable=false)
     */

    private $titleTest;

    /**
     * @var string
     *
     * @ORM\Column(name="matter", type="string", length=60, nullable=false)
     */
    private $matter;

    /**
     * @var string
     *
     * @ORM\Column(name="institution", type="string", length=150, nullable=true)
     */
    private $institution;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="test_init", type="datetime", nullable=true)
     */
    private $testInit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="test_end", type="datetime", nullable=true)
     */
    private $testEnd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_init", type="datetime", nullable=true)
     */
    private $registrationInit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_end", type="datetime", nullable=true)
     */
    private $registrationEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="score_test", type="decimal", precision=100, scale=3, nullable=true)
     */
    private $scoreTest;

    /**
     * @var string
     *
     * @ORM\Column(name="total_percentage", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $totalPercentage;

    /**
     * @var string
     *
     * @ORM\Column(name="test_password", type="string", length=20, nullable=true)
     */
    private $testPassword;

    /**
     * @var \UserSystem
     *
     * @ORM\ManyToOne(targetEntity="UserSystem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user", nullable=false)
     * })
     */
    private $idUser;

    public function getId() {
          return $this->idTest;
    }

    public function getidTest() {
          return $this->idTest;
    }

    public function gettitleTest() {
        return $this->titleTest;
    }
    public function getmatter() {
        return $this->matter;
    }
    public function getinstitution() {
        return $this->institution;
    }
    public function gettestInit() {
        return $this->testInit;
    }
    public function gettestEnd() {
        return $this->testEnd ;
    }

    /**
     * @return \UserSystem
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
    /**
     * @return \DateTime
     */
    public function getRegistrationInit()
    {
        return $this->registrationInit;
    }

    /**
     * @return \DateTime
     */
    public function getRegistrationEnd()
    {
        return $this->registrationEnd;
    }
    public function getdate() {
        return $this->date ;
    }
    public function getscoreTest() {
        return $this->scoreTest ;
    }
    public function gettotalPercentage() {
        return $this->totalPercentage ;
    }
    public function gettestPassword() {
        return $this->testPassword ;
    }

    public function __call($name, $arguments)
    {
        // Nota: el valor $name es sensible a mayúsculas.
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


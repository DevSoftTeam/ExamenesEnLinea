<?php

namespace EvaluationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TestTaken
 *
 * @ORM\Table(name="test_taken", uniqueConstraints={@ORM\UniqueConstraint(name="test_taken_pk", columns={"id_user", "id_test"})}, indexes={@ORM\Index(name="resuelto_fk", columns={"id_test"}), @ORM\Index(name="realiza_1_fk", columns={"id_user"})})
 * @ORM\Entity
 */
class TestTaken
{
    /**
     * @var string
     *
     * @ORM\Column(name="user_score", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $userScore;

    /**
     * @var \UserSystem
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="UserSystem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var \Test
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Test")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_test", referencedColumnName="id_test")
     * })
     */
    private $idTest;


    public function setUserScore($userScore)
    {
        $this->userScore = $userScore;

        return $this;
    }

    public function getUserScore()
    {
        return $this->userScore;
    }
    
    public function getIdUser()
    {
        return $this->idUser;
    }

    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    public function getIdTest()
    {
        return $this->idTest;
    }

    public function setIdTest($idTest)
    {
        $this->idTest = $idTest;
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


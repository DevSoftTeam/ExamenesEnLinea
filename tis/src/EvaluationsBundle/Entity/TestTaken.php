<?php

namespace EvaluationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TestTaken
 *
 * @ORM\Table(name="test_taken", uniqueConstraints={@ORM\UniqueConstraint(name="test_taken_pk", columns={"id_test_taken", "id_user", "id_test"})}, indexes={@ORM\Index(name="resuelto_fk", columns={"id_test"}), @ORM\Index(name="realiza_1_fk", columns={"id_user"})})
 * @ORM\Entity
 */
class TestTaken
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_test_taken", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idTestTaken;

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


}


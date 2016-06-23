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
     * @ORM\Column(name="hour_init", type="date", nullable=true)
     */
    private $hourInit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hour_end", type="date", nullable=true)
     */
    private $hourEnd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

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
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;


}


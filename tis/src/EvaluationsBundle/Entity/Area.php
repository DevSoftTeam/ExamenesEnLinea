<?php

namespace EvaluationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area
 *
 * @ORM\Table(name="area", uniqueConstraints={@ORM\UniqueConstraint(name="area_pk", columns={"id_area"})})
 * @ORM\Entity
 */
class Area
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_area", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="area_id_area_seq", allocationSize=1, initialValue=1)
     */
    private $idArea;

    /**
     * @var string
     *
     * @ORM\Column(name="name_area", type="string", length=40, nullable=false)
     */
    private $nameArea;

    /**
     * @var string
     *
     * @ORM\Column(name="description_area", type="text", nullable=true)
     */
    private $descriptionArea;


}


<?php

namespace EvaluationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeQuestion
 *
 * @ORM\Table(name="type_question", uniqueConstraints={@ORM\UniqueConstraint(name="type_cuestion_pk", columns={"id_type"})})
 * @ORM\Entity
 */
class TypeQuestion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_type", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="type_question_id_type_seq", allocationSize=1, initialValue=1)
     */
    private $idType;

    /**
     * @var string
     *
     * @ORM\Column(name="name_type", type="string", length=30, nullable=false)
     */
    private $nameType;


}


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

    public function getId()
    {
        return $this->idType;
    }

    public function getId_type()
    {
        return $this->idType;
    }

    public function getName_type()
    {
        return $this->nameType;   
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


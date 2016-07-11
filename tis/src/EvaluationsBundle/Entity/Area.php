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

    public function getId() {
        return $this->idArea ;
    }
    public function getIdArea() {
        return $this->idArea ;
    }

    public function getNameArea() {
        return $this->nameArea;
    }

    public function setNameArea($nameArea){
        $this->nameArea = $nameArea;
        return $this;
    }

    public function getDescriptionArea() {
        return $this->descriptionArea;
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


<?php

namespace EvaluationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KeyWord
 *
 * @ORM\Table(name="key_word", uniqueConstraints={@ORM\UniqueConstraint(name="key_word_pk", columns={"id_key_word"})}, indexes={@ORM\Index(name="puede_tener_1_fk", columns={"id_question"})})
 * @ORM\Entity
 */
class KeyWord
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_key_word", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="key_word_id_key_word_seq", allocationSize=1, initialValue=1)
     */
    private $idKeyWord;

    /**
     * @var string
     *
     * @ORM\Column(name="content_word", type="string", length=40, nullable=false)
     */
    private $contentWord;

    /**
     * @var \Question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_question", referencedColumnName="id_question")
     * })
     */
    private $idQuestion;


}


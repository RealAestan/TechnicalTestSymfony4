<?php
/**
 * This file is part of TechnicalTestSymfony4.
 *
 * @author  Anthony Margerand <anthony.margerand@protonmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link    https://github.com/RealAestan/TechnicalTestSymfony4
 */
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="mark")
 *
 * @author Anthony Margerand <anthony.margerand@protonmail.com>
 */
class Mark
{
    /**
     * Default size of page to 30 marks.
     */
    public const PAGE_NUM_ITEMS = 30;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $_id;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string")
     * @Assert\NotBlank()
     */
    private $_subject;

    /**
     * @var float
     *
     * @ORM\Column(name="result", type="float")
     * @Assert\NotBlank()
     * @Assert\Range(min = 0, max = 20)
     * @Assert\Regex("/^[0-9][0-9]?(\.[0-9]+)?/")
     */
    private $_result;

    /**
     * @var Student
     *
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="_marks")
     * @ORM\JoinColumn(name="student_id", nullable=false)
     */
    private $_student;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return (string) $this->_subject;
    }

    /**
     * @return float
     */
    public function getResult(): float
    {
        return (float) $this->_result;
    }

    /**
     * @return Student
     */
    public function getStudent(): Student
    {
        if ($this->_student instanceof Student) {
            return $this->_student;
        }

        return new Student();
    }

    /**
     * @param string $_subject subject
     *
     * @return Mark
     */
    public function setSubject(string $_subject): Mark
    {
        $this->_subject = $_subject;

        return $this;
    }

    /**
     * @param float $_result result
     *
     * @return Mark
     */
    public function setResult(float $_result): Mark
    {
        $this->_result = $_result;

        return $this;
    }

    /**
     * @param Student $_student student
     *
     * @return Mark
     */
    public function setStudent(Student $_student): Mark
    {
        $this->_student = $_student;

        return $this;
    }
}

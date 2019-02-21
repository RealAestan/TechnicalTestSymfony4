<?php
/**
 * This file is part of TechnicalTestSymfony4.
 *
 * @author    Anthony Margerand <anthony.margerand@protonmail.com>
 * @link    https://github.com/RealAestan/TechnicalTestSymfony4
 * @license GPL
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
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $subject;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\Range(min = 0, max = 20)
     * @Assert\Regex("/^[0-2][0-9]?(\.[0-9]+)?/")
     */
    private $result;

    /**
     * @var Student
     *
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="marks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return (string) $this->subject;
    }

    /**
     * @return float
     */
    public function getResult(): float
    {
        return (float) $this->result;
    }

    /**
     * @return Student
     */
    public function getStudent(): Student
    {
        if ($this->student instanceof Student) {
            return $this->student;
        }

        return new Student();
    }

    /**
     * @param string $subject subject
     *
     * @return Mark
     */
    public function setSubject(string $subject): Mark
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param float $result result
     *
     * @return Mark
     */
    public function setResult(float $result): Mark
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @param Student $student student
     *
     * @return Mark
     */
    public function setStudent(Student $student): Mark
    {
        $this->student = $student;

        return $this;
    }
}

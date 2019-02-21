<?php
/*
 * This file is part of TechnicalTestSymfony4.
 *
 * @author Anthony Margerand <anthony.margerand@protonmail.com>
 * @link https://github.com/RealAestan/TechnicalTestSymfony4
 */
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="student")
 *
 * @author Anthony Margerand <anthony.margerand@protonmail.com>
 */
class Student implements \JsonSerializable
{
    /**
     * Default size of page to 10 students.
     */
    public const PAGE_NUM_ITEMS = 20;

    /**
     * Default max results for search to 3 students.
     */
    public const SEARCH_MAX_ITEMS = 3;

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
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="date_immutable")
     * @Assert\NotBlank()
     */
    private $birthDate;

    /**
     * @var Mark[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="Mark",
     *      mappedBy="student",
     *      orphanRemoval=true,
     *      cascade={"persist"}
     * )
     */
    private $marks;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return (string) $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return (string) $this->lastName;
    }

    /**
     * @return Mark[]|ArrayCollection
     */
    public function getMarks()
    {
        return $this->marks;
    }

    /**
     * @return \DateTimeImmutable
     *
     * @throws \Exception if \DateTimeImmutable can't construct
     */
    public function getBirthDate(): \DateTimeImmutable
    {
        if ($this->birthDate instanceof \DateTimeInterface) {
            return $this->birthDate;
        }

        return new \DateTimeImmutable();
    }

    /**
     * @param string $firstName
     *
     * @return Student
     */
    public function setFirstName(string $firstName): Student
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @param string $lastName
     *
     * @return Student
     */
    public function setLastName(string $lastName): Student
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @param \DateTimeImmutable $birthDate
     *
     * @return Student
     */
    public function setBirthDate(\DateTimeImmutable $birthDate): Student
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @param Mark $mark
     *
     * @return Student
     */
    public function addMark(Mark $mark): Student
    {
        $this->marks[] = $mark;

        return $this;
    }

    /**
     * @param Mark $mark
     *
     * @return Student
     */
    public function removeMark(Mark $mark): Student
    {
        $this->marks->removeElement($mark);

        return $this;
    }

    /**
     * Serialize our student to json.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'birthDate' => $this->birthDate->format(\DateTime::W3C),
        ];
    }
}

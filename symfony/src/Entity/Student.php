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
     * @ORM\Column(name="id", type="integer")
     */
    private $_id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string")
     * @Assert\NotBlank()
     */
    private $_firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string")
     * @Assert\NotBlank()
     */
    private $_lastName;

    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="birth_date", type="date_immutable")
     * @Assert\NotBlank()
     */
    private $_birthDate;

    /**
     * @var Mark[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="Mark",
     *      mappedBy="_student",
     *      orphanRemoval=true,
     *      cascade={"persist"}
     * )
     */
    private $_marks;

    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return (string) $this->_firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return (string) $this->_lastName;
    }

    /**
     * @return Mark[]|ArrayCollection
     */
    public function getMarks()
    {
        return $this->_marks;
    }

    /**
     * @return \DateTimeImmutable
     *
     * @throws \Exception if \DateTimeImmutable can't construct
     */
    public function getBirthDate(): \DateTimeImmutable
    {
        if ($this->_birthDate instanceof \DateTimeInterface) {
            return $this->_birthDate;
        }

        return new \DateTimeImmutable();
    }

    /**
     * @param string $_firstName
     *
     * @return Student
     */
    public function setFirstName(string $_firstName): Student
    {
        $this->_firstName = $_firstName;

        return $this;
    }

    /**
     * @param string $_lastName
     *
     * @return Student
     */
    public function setLastName(string $_lastName): Student
    {
        $this->_lastName = $_lastName;

        return $this;
    }

    /**
     * @param \DateTimeImmutable $_birthDate
     *
     * @return Student
     */
    public function setBirthDate(\DateTimeImmutable $_birthDate): Student
    {
        $this->_birthDate = $_birthDate;

        return $this;
    }

    /**
     * @param Mark $mark
     *
     * @return Student
     */
    public function addMark(Mark $mark): Student
    {
        $this->_marks[] = $mark;

        return $this;
    }

    /**
     * @param Mark $mark
     *
     * @return Student
     */
    public function removeMark(Mark $mark): Student
    {
        $this->_marks->removeElement($mark);

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
            'id' => $this->_id,
            'firstName' => $this->_firstName,
            'lastName' => $this->_lastName,
            'birthDate' => $this->_birthDate->format(\DateTime::W3C),
        ];
    }
}

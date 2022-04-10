<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10)]
    private $passport;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'date')]
    private $birthday;

    #[ORM\ManyToOne(targetEntity: University::class, inversedBy: 'students')]
    #[ORM\JoinColumn(nullable: false)]
    private $university;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: StudentResult::class, orphanRemoval: true)]
    private $studentResults;

    #[ORM\ManyToMany(targetEntity: Specialization::class, inversedBy: 'students')]
    private $specializations;

    public function __construct()
    {
        $this->studentResults = new ArrayCollection();
        $this->specializations = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPassport(): ?string
    {
        return $this->passport;
    }

    public function setPassport(string $passport): self
    {
        $this->passport = $passport;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getUniversity(): ?University
    {
        return $this->university;
    }

    public function setUniversity(?University $university): self
    {
        $this->university = $university;

        return $this;
    }

    /**
     * @return Collection<int, StudentResult>
     */
    public function getStudentResults(): Collection
    {
        return $this->studentResults;
    }

    public function addStudentResult(StudentResult $studentResult): self
    {
        if (!$this->studentResults->contains($studentResult)) {
            $this->studentResults[] = $studentResult;
            $studentResult->setStudent($this);
        }

        return $this;
    }

    public function removeStudentResult(StudentResult $studentResult): self
    {
        if ($this->studentResults->removeElement($studentResult)) {
            // set the owning side to null (unless already changed)
            if ($studentResult->getStudent() === $this) {
                $studentResult->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Specialization>
     */
    public function getSpecializations(): Collection
    {
        return $this->specializations;
    }

    public function addSpecialization(Specialization $specialization): self
    {
        if (!$this->specializations->contains($specialization)) {
            $this->specializations[] = $specialization;
        }

        return $this;
    }

    public function removeSpecialization(Specialization $specialization): self
    {
        $this->specializations->removeElement($specialization);

        return $this;
    }
}

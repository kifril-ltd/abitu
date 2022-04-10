<?php

namespace App\Entity;

use App\Repository\UniversityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UniversityRepository::class)]
class University
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'university', targetEntity: Specialization::class, orphanRemoval: true)]
    private $specializations;

    #[ORM\OneToMany(mappedBy: 'university', targetEntity: Student::class, orphanRemoval: true)]
    private $students;

    public function __construct()
    {
        $this->specializations = new ArrayCollection();
        $this->students = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $specialization->setUniversity($this);
        }

        return $this;
    }

    public function removeSpecialization(Specialization $specialization): self
    {
        if ($this->specializations->removeElement($specialization)) {
            // set the owning side to null (unless already changed)
            if ($specialization->getUniversity() === $this) {
                $specialization->setUniversity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setUniversity($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getUniversity() === $this) {
                $student->setUniversity(null);
            }
        }

        return $this;
    }
}

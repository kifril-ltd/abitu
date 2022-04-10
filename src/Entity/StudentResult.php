<?php

namespace App\Entity;

use App\Repository\StudentResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentResultRepository::class)]
class StudentResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'studentResults')]
    #[ORM\JoinColumn(nullable: false)]
    private $student;

    #[ORM\ManyToOne(targetEntity: Subject::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $subject;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $result;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(?int $result): self
    {
        $this->result = $result;

        return $this;
    }
}

<?php

namespace App\Form\DataTransformer;

use App\Entity\Course;
use App\Entity\University;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class UniversityToStringTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($university): string
    {
        if ($university === null) {
            return '';
        }

        return $university->getId();
    }

    public function reverseTransform($universityId): ?University
    {
        if (!$universityId) {
            return null;
        }

        $university = $this->entityManager
            ->getRepository(University::class)
            ->find($universityId)
        ;

        if ($university === null) {
            throw new TransformationFailedException(sprintf(
                'Курс с id "%s" не существует!',
                $universityId
            ));
        }

        return $university;
    }
}

<?php

namespace App\Form;

use App\Entity\Student;
use App\Form\DataTransformer\UniversityToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    private $transformer;

    public function __construct(UniversityToStringTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('passport')
            ->add('name')
            ->add('birthday', DateType::class, [
                'years' => range(date('Y')-60, date('Y')),
            ])
            ->add('university', HiddenType::class);

        $builder->get('university')
            ->addModelTransformer(modelTransformer: $this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}

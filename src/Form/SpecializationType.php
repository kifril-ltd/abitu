<?php

namespace App\Form;

use App\Entity\Specialization;
use App\Form\DataTransformer\UniversityToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecializationType extends AbstractType
{
    private $transformer;

    public function __construct(UniversityToStringTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('code')
            ->add('university', HiddenType::class)
        ;

        $builder->get('university')
            ->addModelTransformer(modelTransformer: $this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Specialization::class,
        ]);
    }
}

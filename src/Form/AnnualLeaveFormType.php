<?php

namespace App\Form;

use App\Entity\AnnualLeave;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnualLeaveFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeOfLeave')
            ->add('startDate')
            ->add('endDate')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('employees')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnnualLeave::class,
        ]);
    }
}

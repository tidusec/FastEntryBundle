<?php

namespace KimaiPlugin\FastEntryBundle\Form;

use App\Form\Type\ActivityType;
use App\Form\Type\CustomerType;
use App\Form\Type\ProjectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class FastEntryItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer', CustomerType::class)
            ->add('project', ProjectType::class)
            ->add('activity', ActivityType::class)
            ->add('duration', NumberType::class, [
                'label' => 'Duration (minutes)',
            ])
            ->add('description', TextType::class)
            ->add('billable', CheckboxType::class, [
                'required' => false,
            ]);
    }
}
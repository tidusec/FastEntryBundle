<?php

namespace KimaiPlugin\FastEntryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class FastEntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entries', CollectionType::class, [
                'entry_type' => FastEntryItemType::class,
                'allow_add' => true,
                'by_reference' => false,
                'prototype' => true,
            ]);
    }
}
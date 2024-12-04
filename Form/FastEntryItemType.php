<?php
namespace KimaiPlugin\FastEntryBundle\Form;

use App\Form\Type\CustomerType;
use App\Form\Type\ProjectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;

class FastEntryItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer', CustomerType::class)
            ->add('project', ProjectType::class)
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'required' => true,
                'format' => \IntlDateFormatter::SHORT,
            ])
            ->add('duration', TimeType::class, [
                'label' => 'Duration (hours:minutes)',
                'input' => 'datetime',
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
            ])
            ->add('description', TextType::class)
            ->add('billable', CheckboxType::class, [
                'required' => false,
            ]);
    }
}
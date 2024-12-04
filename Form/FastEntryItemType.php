<?php
namespace KimaiPlugin\FastEntryBundle\Form;

use App\Form\Type\CustomerType;
use App\Form\Type\ProjectType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FastEntryItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer', CustomerType::class)
            ->add('project', ProjectType::class, [
                'choice_attr' => function ($choice, $key, $value) {
                    return ['data-customer-id' => $choice->getCustomer()->getId()];
                },
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'required' => true,
            ])
            ->add('duration', TextType::class, [
                'label' => 'Duration (hours:minutes)',
                'required' => true,
            ])
            ->add('description', TextType::class)
            ->add('billable', CheckboxType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
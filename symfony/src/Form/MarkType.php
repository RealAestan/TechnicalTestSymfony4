<?php
/*
 * This file is part of TechnicalTestSymfony4.
 *
 * @author Anthony Margerand <anthony.margerand@protonmail.com>
 * @link https://github.com/RealAestan/TechnicalTestSymfony4
 */
declare(strict_types=1);

namespace App\Form;

use App\Entity\Mark;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Defines the form used to create and manipulate marks.
 *
 * @author Anthony Margerand <anthony.margerand@protonmail.com>
 */
class MarkType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', null, [
                'attr' => ['autofocus' => true],
                'label' => 'label.subject',
            ])

            ->add('result', NumberType::class, [
                'label' => 'label.result',
                'scale' => 2,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mark::class,
        ]);
    }
}

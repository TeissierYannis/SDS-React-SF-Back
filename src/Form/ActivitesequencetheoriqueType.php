<?php

namespace App\Form;

use App\Entity\Activitesequencetheorique;
use App\Entity\Atelier;
use App\Entity\Categoriesequence;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivitesequencetheoriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('perfobjectif', NumberType::class, [
                'label' => false,
                'html5' => true,
                'scale' => 1,
                'attr'  => ['length' => 4]])
            ->add('intensiteobjectif', NumberType::class, [
                'label' => false,
                'html5' => true,
                'scale' => 1,
                'attr'  => ['length' => 4]])
            ->add('ordre', HiddenType::class)
            ->add('idsequencetheorique', HiddenType::class)
            ->add('idatelier', EntityType::class, [
                'class' => Atelier::class,
                'choice_label' => function ($atelier) {
                    return $atelier->getTitre();
                },
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activitesequencetheorique::class,
        ]);
    }
}

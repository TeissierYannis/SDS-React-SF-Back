<?php

namespace App\Form;

use App\Entity\Categoriesequence;
use App\Entity\Sequencetheorique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SequencetheoriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, ['label' => 'Titre'])
            ->add('niveau', ChoiceType::class, [
                'choices'  => [
                    'Débutant' => 1,
                    'Confirmé' => 2,
                    'Expert' => 3,
                ],
            ])
            ->add('idcategoriesequence', EntityType::class, [
                'class' => Categoriesequence::class,
                'choice_label' => function ($category) {
                    return $category->getTitre();
                },
                'label' => 'Catégorie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sequencetheorique::class,
        ]);
    }
}

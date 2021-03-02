<?php

namespace App\Form;

use App\Entity\Categoriesequence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class CategoriesequenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('image', FileType::class,[
                'label' => false,
                'multiple' => false,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image()
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categoriesequence::class,
        ]);
    }
}

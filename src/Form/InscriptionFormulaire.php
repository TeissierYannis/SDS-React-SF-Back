<?php
// src/Form/InscriptionFormulaire.php
namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class InscriptionFormulaire extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomUtilisateur', TextType::class, ['label' => 'Nom'])
            ->add('prenomUtilisateur', TextType::class, ['label' => 'Prénom'])
            ->add('login', TextType::class, ['label' => 'Login souhaité'])
            ->add('password', PasswordType::class, ['label' => 'Mot de passe'])
            ->add('passwordConfirm', PasswordType::class, ['label' => 'Confirmation mot de passe','mapped' => false])
            ->add('email', EmailType::class , ['label' => 'Email'])
            ->add('accordPolitiqueSite', CheckboxType::class, ['mapped' => false, 'label' => 'J\'ai lu les conditions d\'utilisation'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
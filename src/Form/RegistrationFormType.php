<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold text-dark mt-2']])
        ->add('nom', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold text-dark mt-2']])
        ->add('prenom', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold text-dark mt-2']])
        ->add('accepter_les_termes_', CheckboxType::class, ['mapped' => false,'constraints' => [ new IsTrue([  'message' => 'vous devez accepter les termes.', ]),],'label_attr' => ['class'=> 'fw-bold text-dark mt-2 me-2']])
        ->add('plainPassword', PasswordType::class, ['mapped' => false,'attr' => ['autocomplete' => 'new-password'],'constraints' => [new NotBlank(['message' => 'Entrez un mot de Passe',]),new Length(['min' => 6,'minMessage' => 'Your password should be at least {{ limit }} characters','max' => 4096,]),],'attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold text-dark mt-2']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

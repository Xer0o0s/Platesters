<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Collections;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AjoutProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
            ->add('prix', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
            ->add('description', TextareaType::class, ['attr' => ['class'=> 'form-control', 'rows'=>'7', 'cols' => '7'], 'label_attr' => ['class'=> 'fw-bold']])
            ->add('image', FileType::class,[
                'label' => "Image de l'article",
                'required' => true,
                'attr' => ['class'=> 'form-control', 'rows'=>'7', 'cols' => '7'], 'label_attr' => ['class'=> 'fw-bold']])
            ->add('minia', FileType::class,[
                'label' => "Minia de l'article",
                'required' => true,
                'attr' => ['class'=> 'form-control', 'rows'=>'7', 'cols' => '7'], 'label_attr' => ['class'=> 'fw-bold']])

            ->add('collection', EntityType::class, ['class' => Collections::class,'choice_label' => 'libelle','attr' => ['class' => 'fw-bold mt-3','7','cols' => '7',],])

                
            ->add('Envoyer', SubmitType::class, ['attr' => ['class'=> 'text-dark btn btn-outline-primary mt-3' ], 'row_attr' => ['class' => 'text-center'],])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Playlist;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre *',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5,
                ],
            ])
            ->add('videoId', TextType::class, [
                'label' => 'ID de la vidéo',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('publishedAt', DateType::class, [
                'label' => 'Date de publication *',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'min' => (new \DateTime())->format('Y-m-d'),
                ],
                'constraints' => [
                    new Assert\GreaterThan([
                        'value' => 'today',
                        'message' => 'La date de publication ne peut pas être dans le passé.',
                    ]),
                ],
            ])
            ->add('playlist', EntityType::class, [
                'class' => Playlist::class,
                'choice_label' => 'name',
                'label' => 'Playlist *',
                'required' => true,
                'placeholder' => 'Sélectionnez une playlist',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'name',
                'label' => 'Catégories',
                'required' => false,
                'multiple' => true,
                'expanded' => false, // true si on veut des checkboxes
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => $options['is_edit'] ? 'Modifier' : 'Créer',
                'attr' => [
                    'class' => 'btn btn-primary mt-3',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => Formation::class,
            'is_edit' => false,
        ]);
    }
}

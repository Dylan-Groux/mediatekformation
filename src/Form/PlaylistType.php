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
use Doctrine\ORM\EntityRepository;
use App\Repository\PlaylistRepository;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class PlaylistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $playlist = $options['playlist'] ?? null;

        $builder
        ->add('name', TextType::class, [
            'label' => 'Nom de la Playlist',
            'required' => true,
            'attr' => ['class' => 'form-control']
        ])
        ->add('description', TextareaType::class, [
            'label' => 'Description',
            'required' => false,
            'attr' => ['class' => 'form-control']
        ]);

        if ($options['formations']) {
            $builder->add('formations', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'title',
                'multiple' => true,
                'label' => 'Formations',
                'attr' => ['class' => 'form-control'],
                'by_reference' => false,
                'query_builder' => function (EntityRepository $er) use ($playlist) {
                    return $er->createQueryBuilder('f')
                        ->innerJoin('f.playlist', 'p')
                        ->where('p.id = :playlistId')
                        ->setParameter('playlistId', $playlist->getId());
                }
            ]);
        }
    
    if ($options['is_edit_formation_paylist']) {
        $builder->add('formations', EntityType::class, [
            'class' => Formation::class,
            'choice_label' => 'title',
            'multiple' => true,
            'expanded' => true,
            'label' => 'Formations',
            'attr' => ['class' => 'form-control'],
            'by_reference' => false
        ]);
    }

    $builder->add('save', SubmitType::class, [
        'label' => $options['is_edit'] ? 'Modifier la Playlist' : 'Ajouter la Playlist',
        'attr' => ['class' => 'btn btn-success']
    ])
    ->add('cancel', ButtonType::class, [
        'label' => 'Annuler',
        'attr' => ['class' => 'btn btn-danger']
    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Playlist::class,
            'is_edit' => false,
            'is_edit_formation_paylist' => false,
            'playlist' => null,
            'formations' => false,
        ]);
    }
}
<?php

namespace App\Form;

use App\Entity\Jeu;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class JeuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Titre', TextType::class)
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                "choice_label" => 'nom',
                'label' => 'Genre',
            ])
            ->add('dateSortie', DateType::class, ['widget' => 'single_text', 'attr' => ['class' => 'form-control']])
            ->add('note', NumberType::class)
            ->add('terminer', CheckboxType::class, [
                'label' => 'Arriver au bout du jeu ?', // Facultatif : étiquette de la case à cocher
                'required' => false, // Indique que le champ n'est pas obligatoire
            ])
            ->add('platine', CheckboxType::class, [
                'label' => 'Le jeu a t-il était platiné?', // Facultatif : étiquette de la case à cocher
                'required' => false, // Indique que le champ n'est pas obligatoire
            ])
            ->add('image', FileType::class, [
                'label' =>  'Ajoute une photo',
                'multiple' => false,
                'mapped' => false,
                'required' => false,
                'constraints' => [

                    new File([
                        'maxSize' => '1024k',
                        'maxSizeMessage' => 'La taille maximale autorisée est de {{ limit }}.',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG, GIF)',
                    ])

                ],
                'label_attr' => ['class' => 'file-label'],
            ])
            ->add('avis', TextareaType::class, [
                'attr' => [
                    'rows' => 8, // Ajustez le nombre de lignes selon vos besoins
                ],
            ])
            //->add('dateTest')
            ->add('Ajouter', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jeu::class,
        ]);
    }
}

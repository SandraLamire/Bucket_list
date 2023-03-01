<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Wish;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            // ajouter liste sélectionnable des noms de catégories
            // écrire category comme dans la BDD
            // ou sinon, mapped => 'false' + récup des données dans le controller
            // EntityType car Category est un objet donc n'arrive pas à faire un toString dessus
            // possible de faire un textType ici + un toString dans Category à la place
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                // callback
                'query_builder' => function (CategoryRepository $categoryRepository) {
                $qb = $categoryRepository->createQueryBuilder('cat');
                $qb->addOrderBy('cat.name');
                return $qb;
                }
            ])
            ->add('description', TextareaType::class, ['required' =>false])
            ->add('author', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}

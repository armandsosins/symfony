<?php
namespace App\Admin;

use App\Entity\User;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ArticleAdmin extends AbstractAdmin
{

    // Configure form fields when creating or editing an Article
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('title')
            ->add('body')
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',  // Or any other field you want to display (e.g., 'email')
                'placeholder' => 'Choose an author',  // Optional placeholder text
            ]);
    }
    protected function configureDatagridFilters(DatagridMapper $dataGrid): void
    {
        $dataGrid
            ->add('title')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('title')
            ->add('body')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('title')
            ->add('body')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
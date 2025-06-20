<?php
namespace App\Admin;

use App\Entity\User;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sonata\DoctrineORMAdminBundle\Filter\DateRangeFilter;


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
                'choice_label' => 'email',
                'placeholder' => 'Choose an author',
            ]);
    }
    protected function configureDatagridFilters(DatagridMapper $dataGrid): void
    {
        $dataGrid
            ->add('title')
            ->add('createdAt', DateRangeFilter::class)
            ->add('updatedAt', DateRangeFilter::class)
            ->add('author', null, [
                'field_type' => EntityType::class,
                'field_options' => [
                    'class' => User::class,
                    'choice_label' => 'email',
                    'placeholder' => 'Choose an author',
                ],
            ]);

    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('title')
            ->add('author.email')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('title')
            ->add('body')
            ->add('author.email')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
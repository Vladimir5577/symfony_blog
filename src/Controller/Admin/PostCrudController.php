<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use Doctrine\DBAL\Types\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }


    public function configureFields(string $pageName): iterable
    {
//        yield ImageField::new('image')
//            ->setBasePath('/photo/uploads')
//            ->setLabel('Photo')
//            ->setUploadDir('/public/photo/uploads')
//            ->onlyOnForms();
//        yield TextField::new('title');

        return [
            IdField::new('id')
                ->onlyOnIndex(),
            ImageField::new('image')
                ->setBasePath('/photo/uploads')
                ->setUploadDir('/public/photo/uploads')
                ->setLabel('Photo')
            ,
            AssociationField::new('user_id')
                ->setQueryBuilder(function () {
                    dd('blablad');
                    return 'bal';
                })
                ->setLabel('User details')
                ->onlyOnIndex(),
            TextField::new('getUserName')
                ->setLabel('User')
                ->onlyOnIndex(),
            TextField::new('title'),

            TextEditorField::new('description')
                ->onlyOnForms(),
            BooleanField::new('is_active'),

        ];
    }

}

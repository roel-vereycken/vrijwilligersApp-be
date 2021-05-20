<?php

namespace App\Controller\Admin;

use App\Entity\Locatie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LocatieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Locatie::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

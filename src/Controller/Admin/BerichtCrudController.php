<?php

namespace App\Controller\Admin;

use App\Entity\Bericht;
use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BerichtCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bericht::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('body'),
            AssociationField::new("eventBericht", "Evenement")->autocomplete(),
            AssociationField::new("userBericht", "User")
        ];
    }


}

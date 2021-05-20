<?php

namespace App\Controller\Admin;

use App\Entity\Opmerking;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OpmerkingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Opmerking::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('body'),
            AssociationField::new("opmerkingBericht", "Bericht")->autocomplete(),
            AssociationField::new("opmerkingOpmerking", "Opmerking")->autocomplete(),
            AssociationField::new("opmerkingUser", "User")->autocomplete()
        ];
    }

}

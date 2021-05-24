<?php

namespace App\Controller\Admin;

use App\Entity\Opmerking;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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

    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)

            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)

            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action
                    ->setLabel("Voeg nieuwe opmerking toe")
                    ->setIcon("fa fa-plus");
            }
            )
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action
                    ->setLabel("Pas aan")
                    ->setIcon("fa fa-pencil");
            }
            )
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->setLabel("Verwijder")
                    ->setIcon("fa fa-trash");
            }
            )
            ->update(Crud::PAGE_NEW,Action::SAVE_AND_RETURN, function (Action $action) {
                return $action
                    ->setLabel("Maak nieuwe opmerking aan");
            }
            )
            ->update(Crud::PAGE_EDIT,Action::SAVE_AND_RETURN, function (Action $action) {
                return $action
                    ->setLabel("Pas opmerking aan");
            }
            );
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle("index", "Opmerkingen")
            ->setPageTitle("new", "Nieuwe opmerking")
            ->setPageTitle("edit", "Werk opmerking bij");
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

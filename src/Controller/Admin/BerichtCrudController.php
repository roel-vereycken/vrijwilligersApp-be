<?php

namespace App\Controller\Admin;

use App\Entity\Bericht;
use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BerichtCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bericht::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)

            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)

            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action
                    ->setLabel("Voeg nieuw bericht toe")
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
                    ->setLabel("Maak nieuw bericht aan");
            }
            )
            ->update(Crud::PAGE_EDIT,Action::SAVE_AND_RETURN, function (Action $action) {
                return $action
                    ->setLabel("Pas bericht aan");
            }
            );
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle("index", "Berichten")
            ->setPageTitle("new", "Nieuw bericht")
            ->setPageTitle("edit", "Werk bericht bij");
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextEditorField::new('body')->onlyOnForms(),
            TextareaField::new('body')->onlyOnIndex(),
            AssociationField::new("eventBericht", "Evenement")->autocomplete(),
            AssociationField::new("userBericht", "User")
        ];
    }


}

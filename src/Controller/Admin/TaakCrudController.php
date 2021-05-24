<?php

namespace App\Controller\Admin;

use App\Entity\Taak;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TaakCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Taak::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)

            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action
                    ->setLabel("Voeg een nieuwe taak toe")
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
                    ->setLabel("Maak nieuwe taak aan");
                }
            )
            ->update(Crud::PAGE_NEW,Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action
                    ->setLabel("Maak taak aan en voeg nog een toe");
                }
            )
            ->update(Crud::PAGE_EDIT,Action::SAVE_AND_RETURN, function (Action $action) {
            return $action
                ->setLabel("Pas taak aan");
                }
            );
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle("index", "Taken")
            ->setPageTitle("new", "Nieuwe taak")
            ->setPageTitle("edit", "Werk taak bij");
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

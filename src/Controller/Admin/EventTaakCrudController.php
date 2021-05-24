<?php

namespace App\Controller\Admin;

use App\Entity\EventTaak;
use App\Entity\Taakverdeling;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use PhpParser\Node\Expr\Array_;

class EventTaakCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EventTaak::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)

            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action
                    ->setLabel("Voeg nieuwe taakverdeling toe")
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
                    ->setLabel("Maak nieuwe taakverdeling aan");
            }
            )
            ->update(Crud::PAGE_NEW,Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action
                    ->setLabel("Maak taakverdeling aan en voeg er nog een toe");
            }
            )
            ->update(Crud::PAGE_EDIT,Action::SAVE_AND_RETURN, function (Action $action) {
                return $action
                    ->setLabel("Pas taakverdeling aan");
            }
            );
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle("index", "Taakverdeling")
            ->setPageTitle("new", "Nieuwe taakverdeling")
            ->setPageTitle("edit", "Werk taakverdeling bij");
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new("eventId", "Evenement"),
            AssociationField::new("taakId", "Taak"),
            CollectionField::new("users", "Vrijwilligers")->setSortable(false),
            AssociationField::new("users", "Vrijwilligers")
                  ->onlyOnForms()
                  ->setTemplatePath('list.html.twig')
                    ->setFormTypeOptions([
                        'by_reference' => false,
                    ]),
            DateField::new("Datum"),
            TimeField::new("Startuur"),
            TimeField::new("Einduur"),
        ];
    }

}

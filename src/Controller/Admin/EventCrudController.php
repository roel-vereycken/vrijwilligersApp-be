<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)

            ->remove(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE)

            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action
                    ->setLabel("Voeg nieuw evenement toe")
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
                    ->setLabel("Maak nieuw evenement");
                }
            );
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle("index", "Evenementen")
            ->setPageTitle("new", "Nieuw evenement")
            ->setPageTitle("edit", "Werk evenement bij");
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('Naam'),
            TextField::new('Beschrijving'),
            AssociationField::new("eventCategorie", "Categorie"),
            AssociationField::new("eventLocatie", "Locatie"),
            DateField::new("Startdatum"),
            DateField::new("Einddatum"),
            TextAreaField::new("afbeeldingFile")
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),
            ImageField::new('Afbeelding')
                ->setBasePath('/images/afbeeldingen')
                ->hideOnForm(),
            CollectionField::new("eventTaken", "Taken")->onlyOnIndex(),

        ];
    }

}

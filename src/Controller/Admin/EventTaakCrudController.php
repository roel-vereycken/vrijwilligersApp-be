<?php

namespace App\Controller\Admin;

use App\Entity\EventTaak;
use App\Entity\Taakverdeling;
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

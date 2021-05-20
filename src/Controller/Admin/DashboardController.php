<?php

namespace App\Controller\Admin;

use App\Entity\Bericht;
use App\Entity\Categorie;
use App\Entity\Event;
use App\Entity\EventTaak;
use App\Entity\Locatie;
use App\Entity\Opmerking;
use App\Entity\Taak;
use App\Entity\Taakverdeling;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        {
            $routeBuilder = $this->get(AdminUrlGenerator::class);

            return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('VrijwilligersApp');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section("Vrijwilligers");

        yield MenuItem::linktoDashboard('Vrijwilligers', 'fa fa-users');

        yield MenuItem::section("Evenementen");

        yield MenuItem::linkToCrud('Evenementen', 'fa fa-calendar', Event::class);

        // Tussentitel voor de takensectie
        yield MenuItem::section("Taken");
        // Verwijzingen naar de juiste controllers ivm taken
        yield MenuItem::linkToCrud('Taken', 'fa fa-tasks', Taak::class);
        yield MenuItem::linkToCrud('Taak op evenement', 'fa fa-tasks', EventTaak::class);

        yield MenuItem::section("Berichten/opmerkingen");

        yield MenuItem::linkToCrud('Berichten', 'fa fa-comment', Bericht::class);
        yield MenuItem::linkToCrud('Opmerkingen', 'fa fa-comments', Opmerking::class);

        // Tussentitel voor de specificaties
        yield MenuItem::section("Specificaties");

        yield MenuItem::linkToCrud('Categorie', 'fa fa-book', Categorie::class);
        yield MenuItem::linkToCrud('Locatie', 'fa fa-compass', Locatie::class);
    }
}

<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Vehicule;
use App\Service\NameFile;
use App\Form\VehiculeType;
use App\Form\Commande1Type;
use App\Repository\CommandeRepository;
use App\Repository\VehiculeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/vehicule')]
class VehiculeController extends AbstractController
{
    #[Route('/', name: 'app_vehicule_index', methods: ['GET'])]
    public function index(VehiculeRepository $vehiculeRepository): Response
    {
        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehiculeRepository->findAll(),
        ]);
    }

    #[Route('list-vehicule', name: 'app_vehicule_show_vehicule', methods: ['GET'])]
    public function show_vehicule(VehiculeRepository $vehiculeRepository): Response
    {
        return $this->render('vehicule/vehicules.html.twig', [
            'vehicules' => $vehiculeRepository->findAll(),
        ]);
    }

    #[Route('/commande', name: 'app_vehicule_commande', methods: ['GET', 'POST'])]
    public function commande(Request $request, CommandeRepository $commandeRepository): Response
    {
        $commande = new Commande();
        $form = $this->createForm(Commande1Type::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commande->setCreateAt(new \DateTime("now"));
            $commandeRepository->add($commande, true);

            return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicule/ficheVehicule.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }



    #[Route('/new', name: 'app_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VehiculeRepository $vehiculeRepository, NameFile $NameFile): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $vehicule->setCreateAt(new \DateTime("now"));
            $imageFile = $form->get('imageFile')->getData();

            if($imageFile)
            {

                $nomimage = $NameFile->renamefile($imageFile);

                $imageFile->move(
                    $this->getParameter('imageVehicule'),
                    $nomimage
                );

                $vehicule->setImage($nomimage);
            }

            $vehiculeRepository->add($vehicule, true);

            return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicule/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehicule_show', methods: ['GET'])]
    public function show(Vehicule $vehicule): Response
    {
        return $this->render('vehicule/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicule $vehicule, VehiculeRepository $vehiculeRepository, NameFile $NameFile): Response
    {
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $imageFile = $form->get('imageFile')->getData();

            if($imageFile)
            {

                $nomimage = $NameFile->renamefile($imageFile);

                $imageFile->move(
                    $this->getParameter('imageVehicule'),
                    $nomimage
                );

                $vehicule->setImage($nomimage);

               if($vehicule->getImage())
               {
                    unlink($this->getParameter('imageVehicule'). "/" . $vehicule->getImage());
               }

            }


            $vehiculeRepository->add($vehicule, true);

            return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicule/edit.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vehicule_delete', methods: ['POST'])]
    public function delete(Request $request, Vehicule $vehicule, VehiculeRepository $vehiculeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicule->getId(), $request->request->get('_token'))) {

            if($vehicule->getImage())
            {
                unlink($this->getParameter('imageVehicule'). "/" . $vehicule->getImage());
            }
            $vehiculeRepository->remove($vehicule, true);
        }

        return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
    }
}

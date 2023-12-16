<?php

namespace App\Controller;

use DateTime;
use App\Entity\Jeu;
use App\Form\JeuType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JeuController extends AbstractController
{
    #[Route('/', name: 'app_jeu')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $jeux = $doctrine->getRepository(Jeu::class)->findBy([], ["Titre" => "ASC"]);

        return $this->render('jeu/index.html.twig', [
            'jeux' => $jeux,
        ]);
    }

    #[
        Route('/jeu/add', name: 'add_jeu'),
        Route('/jeu/edit/{id}', name: 'edit_jeu')
    ]
    public function add(ManagerRegistry $doctrine, Jeu $jeu = null, Request $request): Response
    {

        if (!$jeu) {
            $jeu = new Jeu();
        }
        $imagePath = $jeu->getImage();

        $form = $this->createForm(JeuType::class, $jeu); // crée mon formulaire à partir du builder EntrepriseType
        $form->handleRequest($request); // quand une action est effectué sur le formulaire, récupère les données

        if ($form->isSubmitted() && $form->isValid()) {
            // on recupere l'image transmise
            $image = $form->get('image')->getData();
            if ($image) {
                // on genere un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // on copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // on stocke l'image dans la base de données
                $jeu->setImage($fichier);
            } else {
                // Aucun nouveau fichier, restaurer le chemin de l'image existante
                $jeu->setImage($imagePath);
            }

            $now = new DateTime(); // objet date
            $jeu->setDateTest($now); // installe ma date
            $entityManager = $doctrine->getManager();
            $entityManager->persist($jeu);
            $entityManager->flush();

            return $this->redirectToRoute('app_jeu');
        }

        // vue pour formulaire
        return $this->render('jeu/add.html.twig', [
            'formAddJeu' => $form->createView(),
            'edit' => $jeu->getId(), //important pour verifier si employe existe et mettre une condition sur la view
        ]);
    }

    #[Route('/jeu/show/{id}', name: 'show_jeu')]
    public function show(ManagerRegistry $doctrine, Jeu $jeu = null, Request $request): Response
    {
        if ($jeu === null) {
            // Si le produit n'existe pas, redirigez l'utilisateur vers une page d'erreur ou une autre page appropriée.
            return $this->redirectToRoute('app_home');
        }



        return $this->render('jeu/show.html.twig', [
            'controller_name' => 'HomeController',
            'jeu' => $jeu,
        ]);
    }


    #[Route('/jeu/delete/{id}', name: 'delete_jeu')] // supprimer le produit
    public function delete(ManagerRegistry $doctrine, Jeu $jeu = null): Response
    {
        if ($jeu) {

            $entityManager = $doctrine->getManager();

            // Supprimer les images associées
            $image = $jeu->getImage();


            $imagePath = $this->getParameter('images_directory') . '/' . $image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $entityManager->remove($jeu);



            // Supprimer le jeu
            $entityManager->remove($jeu);
            $entityManager->flush();

            return $this->redirectToRoute('app_jeu');
        } else {
            return $this->redirectToRoute('app_jeu');
        }
    }
}

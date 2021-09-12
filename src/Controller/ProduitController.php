<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\DateTimeInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Form\FormInterface;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="produit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitFile = $form['photo2']->getPhoto();
            // vérification s'il y a un upload photo
            if ($produitFile) {
                // renommage du fichier
                // nom du fichier + extension
                $newPhoto = $produit . '.' . $produitFile->guessExtension();
                // assignation de la valeur à la propriété picture à l'aide du setter
                $produit->setPhoto($newPhoto);
                try {
                    // déplacement du fichier vers le répertoire de destination sur le serveur
                    $produitFile->move(
                        $this->getParameter('photo_directory'),
                        $newPhoto
                    );
                } catch (FileException $e) {
                    // gestion de l'erreur si le déplacement ne s'est pas effectué
                }
            }
            $produit->getDateAjout(new \DateTimeInterface);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Produit ajouté avec succès !!'
            );
            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitFile = $form['photo2']->setPhoto();
            if ($produitFile) {
                // renommage du fichier
                // nom du fichier + extension
                $newPhoto = $produit . '.' . $produitFile->guessExtension();
                // assignation de la valeur à la propriété picture à l'aide du setter
                $produit->setPhoto($newPhoto);
                try {
                    // déplacement du fichier vers le répertoire de destination sur le serveur
                    $produitFile->move(
                        $this->getParameter('photo_directory'),
                        $newPhoto
                    );
                } catch (FileException $e) {
                    // gestion de l'erreur si le déplacement ne s'est pas effectué
                }
            }
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                'Produit modifé avec succès !!'
            );
            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }
        $this->addFlash(
            'success',
            'Produit supprimé avec succès !!'
        );
        return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
    }
}

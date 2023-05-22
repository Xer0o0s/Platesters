<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Form\AjoutProduitType;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\ModifArtType;
use App\Form\CollectionsType;
use App\Entity\Produit;
use App\Entity\Collections;
use Symfony\Component\String\Slugger\SluggerInterface;


class AdminController extends AbstractController
{





    #[Route('/admin-ajprod', name: 'ajout_produit')]
    public function ajoutprod(Request $request, EntityManagerInterface $entityManagerInterface, SluggerInterface $slugger): Response
    {
        $produits = new Produit();
        $form = $this->createForm(AjoutProduitType::class, $produits);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $fichier = $form->get('image')->getData();
                
                if($fichier){
                 $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                 $nomFichier = $slugger->slug($nomFichier);
                 $nomFichier = $nomFichier.'-'.uniqid().'.'.$fichier->guessExtension();
                    try{                 
                        $fichier->move($this->getParameter('file_directory'), $nomFichier);
                        $produits->setImage($nomFichier);
                        $this->addFlash('notice', 'Fichier envoyé');
                    }
                    catch(FileException $e){
                        $this->addFlash('notice', 'Erreur d\'envoi');
                    }        
                }
                $fichier1 = $form->get('minia')->getData();
                
                if($fichier1){
                 $nomFichier1 = pathinfo($fichier1->getClientOriginalName(), PATHINFO_FILENAME);
                 $nomFichier1 = $slugger->slug($nomFichier1);
                 $nomFichier1 = $nomFichier1.'-'.uniqid().'.'.$fichier1->guessExtension();
                    try{                 
                        $fichier1->move($this->getParameter('file_minia'), $nomFichier1);
                        $produits->setMinia($nomFichier1);
                        $this->addFlash('notice', 'Fichier envoyé');
                    }
                    catch(FileException $e){
                        $this->addFlash('notice', 'Erreur d\'envoi');
                    }        
                }
                $produits->setNbfavoris(0);
                $entityManagerInterface->persist($produits);
                $entityManagerInterface->flush();
                return $this->redirectToRoute('ajout_produit');
            }
        }
        return $this->render('admin/ajoutproduit.html.twig', [
            'form'=>$form->createView(),
            'produits'=>$produits
        ]);
    }







    #[Route('/admin-liste-produits', name: 'liste-produits')]
    public function listeprod(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $repoProduits = $entityManagerInterface->getRepository(Produit::class);
        $produits = $repoProduits->findAll();
        return $this->render('admin/listprod.html.twig', [
        'produits' => $produits
        ]);
    }






    #[Route('/admin-supp-produits/{id}', name: 'supp-produits')]
    public function suppeprod(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $id=$request->get('id');
        $repoProduits = $entityManagerInterface->getRepository(Produit::class);
        $produits = $repoProduits->find($id);
        $entityManagerInterface->remove($produits);
        $entityManagerInterface->flush();
    return $this->redirectToRoute('liste-produits');
    }










    #[Route('/admin-modif-produit', name: 'modif-produit')]
    public function modifArt(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $id=$request->get('id');
        $repoProduits = $entityManagerInterface->getRepository(Produit::class);
        $produits = $repoProduits->find($id);

        $form=$this->createForm(ModifArtType::class,$produits);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $entityManagerInterface->persist($produits);
                $entityManagerInterface->flush();
                $this->addFlash('notice','modifié');
                return $this->redirectToRoute('liste-produits');
            }
        }
        return $this->render('admin/modifprod.html.twig', [
        'form'=> $form-> createView()
        ]);
    }










    #[Route('/admin-ajcoll', name: 'ajout_collection')]
    public function ajoutcoll(Request $request, EntityManagerInterface $entityManagerInterface, SluggerInterface $slugger): Response
    {
        $collections = new Collections();
        $form = $this->createForm(CollectionsType::class, $collections);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $fichier2 = $form->get('image')->getData();
                
                if($fichier2){
                 $nomFichier2 = pathinfo($fichier2->getClientOriginalName(), PATHINFO_FILENAME);
                 $nomFichier2 = $slugger->slug($nomFichier2);
                 $nomFichier2 = $nomFichier2.'-'.uniqid().'.'.$fichier2->guessExtension();
                    try{                 
                        $fichier2->move($this->getParameter('file_coll'), $nomFichier2);
                        $collections->setImage($nomFichier2);
                        $this->addFlash('notice', 'Fichier envoyé');
                    }
                    catch(FileException $e){
                    $this->addFlash('notice', 'Erreur d\'envoi');
                }        
            }
            $entityManagerInterface->persist($collections);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('ajout_collection');
            }
        }
        return $this->render('admin/ajoutcoll.html.twig', [
        'form'=>$form->createView(),
        'collections'=>$collections]);
    }

    #[Route('/admin-liste-collections', name: 'liste-collections')]
    public function listecollections(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $repoCollections = $entityManagerInterface->getRepository(Collections::class);
        $collections = $repoCollections->findAll();
        return $this->render('admin/listcoll.html.twig', [
            'collections'=>$collections
        ]);
    }
}

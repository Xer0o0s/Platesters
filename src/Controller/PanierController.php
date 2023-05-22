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
use App\Entity\Produit;
use App\Entity\Panier;
use App\Entity\Ajouter;
use Symfony\Component\String\Slugger\SluggerInterface;

class PanierController extends AbstractController
{
    #[Route('/private-panier', name: 'panier')]
    public function index(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        if ($this->getUser()->getPanier() == NULL) {
            $this->getUser()->setPanier(new Panier());
            $entityManagerInterface->persist($this->getUser());
            $entityManagerInterface->flush();
        }
        return $this->render('panier/panier.html.twig', [
        ]);
    }
    #[Route('/private-edit-panier', name: 'editpanier')]
    public function edit_panier(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $id = $request->get('id');
        $action = $request->get('action');
        $panier = $entityManagerInterface->getRepository(Panier::class)->find($this->getUser()->getPanier());
        $produits = $panier->getAjouters();
        $ajouter = $entityManagerInterface->getRepository(Ajouter::class)->find($id);
        $produit = $entityManagerInterface->getRepository(Produit::class)->find($id);

        if ($action == 'ajouter') {
            if ($this->getUser()->getPanier() == null) {
                $this->getUser()->setPanier(new Panier());
                $entityManagerInterface->persist($this->getUser());
                $entityManagerInterface->flush();
                $new_ajout = new Ajouter;
                $new_ajout->setPanier($panier);
                $new_ajout->setQte(1);
                $new_ajout->setProduit($produit);
                $entityManagerInterface->persist($new_ajout);
            } 
            $existeAjouter = $entityManagerInterface->getRepository(Ajouter::class)->findOneBy([
                'panier' => $panier,
                'produit' => $produit
            ]);
            if ($existeAjouter){
                $existeAjouter->setQte($existeAjouter->getQte() + 1);
                $entityManagerInterface->persist($existeAjouter);
            } else {
                $new_ajout = new Ajouter;
                $new_ajout->setPanier($panier);
                $new_ajout->setQte(1);
                $new_ajout->setProduit($produit);
                $entityManagerInterface->persist($new_ajout);
            }
        }
        if ($action == 'addqte') {
            $ajouter->setQte($ajouter->getQte()+1);

            $entityManagerInterface->persist($ajouter);
        }
        if ($action == 'suppqte') {
            if ($ajouter->getQte()>=1) {
                $ajouter->setQte($ajouter->getQte()-1);
                $entityManagerInterface->persist($ajouter);
            }
            if ($ajouter->getQte()==0) {
                $panier->removeAjouter($ajouter);
                $entityManagerInterface->persist($panier);
            }
        }
        if ($action == 'supprimer') {
            $panier->removeAjouter($ajouter);
            $entityManagerInterface->persist($panier);
        }
        $entityManagerInterface->flush();
        return $this->redirectToRoute('panier');
        return $this->render('panier/panier.html.twig', [
        ]);
    }
}

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
use Symfony\Component\String\Slugger\SluggerInterface;

class FavorisController extends AbstractController
{
    #[Route('/favoris', name: 'favoris')]
    public function index(Request $request,EntityManagerInterface $entityManagerInterface): Response
    {
        $id=$request->get('id');
        $action = $request->get('action');
        $produits=$entityManagerInterface->getrepository(Produit::class)->find($id);
        if($action=="supprimer"){
            $this->getUser()->removeFavori($produits);
        }
        if($action=="ajouter"){
            $this->getUser()->addFavori($produits);
        }
        $entityManagerInterface->persist($this->getUser());
        $entityManagerInterface->flush();
        return $this->redirectToRoute('afffavoris');
    }
    #[Route('/private-favoris', name: 'afffavoris')]
    public function favori(): Response
    {
        return $this->render('favoris/favoris.html.twig', [

        ]);
    }
}

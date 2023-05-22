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

class CollectionsController extends AbstractController
{
    #[Route('/collections', name:'collections')]
    public function coll(Request $request, EntityManagerInterface $entityManagerInterface, SluggerInterface $slugger): Response
    {
        $repoCollections = $entityManagerInterface->getRepository(Collections::class); 
        $collections = $repoCollections->findAll();
        return $this->render('collections/collections.html.twig', [
            'collections'=>$collections
          
        ]);
    }
    #[Route('/incollections', name:'incollections')]
    public function incoll(Request $request): Response
    {
        $id = $request->get('id');
        $collections = $this->getDoctrine()->getRepository(Collections::class)->find($id);
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findBy(['collection' => $collections]);

        return $this->render('collections/incollections.html.twig', [
            'produits' => $produits,
            'collections'=>$collections
        ]);
    } 
}

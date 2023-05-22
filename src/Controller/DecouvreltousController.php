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
use App\Entity\Produit;
use Symfony\Component\String\Slugger\SluggerInterface;

class DecouvreltousController extends AbstractController
{
    #[Route('/DLT', name: 'Découvre les tous')]
    public function DLT(EntityManagerInterface $entityManagerInterface) {
     
        $repoProduits = $entityManagerInterface->getRepository(Produit::class); 
        $produits = $repoProduits->findAll();
        return $this->render('decouvreltous/DLT.html.twig', [
            'produits'=>$produits
          
        ]);
    }
}

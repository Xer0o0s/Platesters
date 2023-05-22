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

class ProduitsController extends AbstractController
{
    #[Route('/produits/{id}', name: 'produit_en_détail')]
    public function detailprod(Request $request, int $id ,EntityManagerInterface $entityManager): Response
    {   
        $entitryManager = $this->getDoctrine()->getManager();
        $produits = $entityManager->getRepository(Produit::class)->find($id);
        if (!$produits) {
            throw $this->createNotFoundException("Aucun produit trouvé a l'id".$id);
        }
        return $this->render('produits/produit.html.twig', [
            'produit'=>$produits,
        ]);
    }
}

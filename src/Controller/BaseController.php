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
use App\Entity\Collections;
use Symfony\Component\String\Slugger\SluggerInterface;

class BaseController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produits = $entityManager->getRepository(Produit::class)->findBy([], ['id' => 'ASC'], 5);
        $collections = $entityManager->getRepository(Collections::class)->findBy([], ['id' => 'ASC'], 2);

        return $this->render('base/index.html.twig', [
            'produits' => $produits,
            'collections'=>$collections
        ]);
    }
    #[Route('/mention-legales', name: 'qu est ce que Platester')]
    public function apropos(): Response
    {
        return $this->render('base/qcqp.html.twig', [
          
        ]);
    }
    #[Route('/profile', name: 'profile')]
    public function profile(): Response
    {
        return $this->render('base/profile.html.twig', [
          
        ]);
    }
}
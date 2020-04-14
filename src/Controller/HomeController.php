<?php

namespace App\Controller;

use App\Entity\Ennemi;
use App\Entity\Joueur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $em)
    {
        $isDead = false;
        $pseudo = $em->getRepository(Joueur::class)->find(1);
        $ennemi = $em->getRepository(Ennemi::class)->find(1);

      if($ennemi->getPv() <= 0)
      {


        $isDead = true;
      }

        return $this->render('home/index.html.twig', [
            'pseudo' => $pseudo,
            'ennemi' => $ennemi,
            'isDead' => $isDead,
        ]);
    }


    /**
     * @Route("/attaque", name="attaque")
     */
    public function attaque(EntityManagerInterface $em)
    {
        $pseudo = $em->getRepository(Joueur::class)->find(1);
        $ennemi = $em->getRepository(Ennemi::class)->find(1);

        $isDead = false;

        if($ennemi->getPv() <= 0)
        {


          $isDead = true;
        }
        else
        {
          $ennemi->setPv($ennemi->getPv() - $pseudo->getAttaque());

          $em->persist($ennemi);
          $em->flush();
        }

        //$blabla = "Je suis une phrase";

      return $this->render('home/index.html.twig', [
        'pseudo' => $pseudo,
        'ennemi' => $ennemi,
        'isDead' => $isDead,
      ]);
    }


    /**
     * @Route("/attaqueEnnemi", name="attaqueEnnemi")
     */
    public function attaqueEnnemi(EntityManagerInterface $em)
    {
        $pseudo = $em->getRepository(Joueur::class)->find(1);
        $ennemi = $em->getRepository(Ennemi::class)->find(1);

        $pseudo->setPv($pseudo->getPv() - $ennemi->getAttaque());
        $em->persist($ennemi);
        $em->flush();


        return $this->redirectToRoute('home');
    }
}

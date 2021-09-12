<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 50; $i++) {
            $produit = new Produit();
            $produit->setReference("reference de $i")
                ->setLibelle("libelle de $i")
                ->setDescription("description de $i")
                ->setPrix(10)
                ->setStock(100)
                ->setCouleur("couleur de $i")
                ->setPhoto("http://placehold.it/50*25")
                ->setCategorie("categorie de $i")
                ->setDateAjout(new \DateTime());
            $manager->persist($produit);
        }


        $manager->flush();
    }
}

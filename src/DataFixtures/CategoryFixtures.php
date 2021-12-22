<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;


/* 

Les fixtures sont un jeu de données.
Elles servent à remplir la BDD juste après la 
création de la BDD, pour pouvoir manipuler des
données dans mon code => des entités

*/

class CategoryFixtures extends Fixture
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger) {
        
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Politique', 
            'Societé', 
            'economie', 
            'santé', 
            'environnement', 
            'sport', 
            'culture'
        ];
        
        //permet de crocheté sur un tableau comme une boucle for
        foreach($categories as $category) { 
  
        $cat = new Category();

        $cat->setName($category);
        $cat->setAlias($this->slugger->slug($category));
        //codez la suite jusquau flush()
        //creer une categorie

        $manager->persist($cat);

       }

        $manager->flush();

    }
}

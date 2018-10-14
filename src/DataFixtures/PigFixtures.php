<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Pig;

class PigFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $index;
        $numbersPigsToCreate=10;
        
        for($index = 0 ; $index < $numbersPigsToCreate ; $index++){
            $pig = new Pig();
            $pig->setPseudoName("pig_".$index);
            $pig->setEmail("pig_".$index."@yopmail.net");
            $pig->setPassword("pig".$index);
            $manager->persist($pig);
        }
        
        $manager->flush();
    }
}

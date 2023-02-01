<?php

namespace App\DataFixtures;

use App\Entity\Decision;
use app\Entity\Species;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SpeciesFixtures extends Fixture
{
    public const ESPECES = [
        ['name' => 'Canidés'],
        ['name' => 'Félidés'],
        ['name' => 'Bovidés'],
        ['name' => 'Galinacés'],
        ['name' => 'équidés'],
        ['name' => 'Muridés'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::ESPECES as $key => $espece) {
            $species = new species();
            $species -> setName($espece['name']);
            $manager->persist($species);
            $this->addReference('species_' . $key, $species);
        }

        $manager->flush();
    }
}

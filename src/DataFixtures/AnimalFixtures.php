<?php

namespace App\DataFixtures;

use App\entity\Animal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnimalFixtures extends Fixture implements DependentFixtureInterface
{
    public const LIST = [
        [
            'breed' => 'Beagle',
            'name' => 'Ralf',
            'age' => '5',
            'picture' => '',
            'description' => 'Je suis très attachant et j\'adore jouer avec les enfants.',
            'reference' => 'species_0',
            'owner' => 'user_0'
        ],
        [
            'breed' => 'Golden Retriever',
            'name' => 'Mighty',
            'age' => '8',
            'picture' => '',
            'description' => 'J\'adore les caresses et jouer avec des balles de tennis.',
            'reference' => 'species_0',
            'owner' => 'user_1',
        ],
        [
            'breed' => 'Persan',
            'name' => 'Princesse',
            'age' => '4',
            'picture' => '',
            'description' => 'Je suis aussi douce qu\'une peluche et très calme.',
            'reference' => 'species_1',
            'owner' => 'user_1',
        ],
        [
            'breed' => 'Mouton',
            'name' => 'Coco',
            'age' => '4',
            'picture' => '',
            'description' => 'Lachez-moi dans votre jardin et je vous tonds la pelouse parfaitement.',
            'reference' => 'species_2',
            'owner' => 'user_0',
        ],
        [
            'breed' => 'Poule',
            'name' => 'Cocotte',
            'age' => '1',
            'picture' => '',
            'description' => 'Avec un peu de chance, je pondrais assez d\'oeufs pour faire une crêpe-party.',
            'reference' => 'species_3',
            'owner' => 'user_0'
        ],
        [
            'breed' => 'Cheval comtois',
            'name' => 'Hector',
            'age' => '4',
            'picture' => '',
            'description' => 'Je suis très endurant et résistant. Je suis docile et patient. Je suis un bon cheval de travail et de loisir.',
            'reference' => 'species_4',
            'owner' => 'user_0'
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::LIST as $key => $someOne) {
            $animal = new Animal();
            $animal -> setBreed($someOne['breed']);
            $animal -> setName($someOne['name']);
            $animal -> setAge($someOne['age']);
            $animal -> setPicture($someOne['picture']);
            $animal -> setDescription($someOne['description']);
            $animal -> setSpecies($this->getReference($someOne['reference']));
            $animal -> setOwner($this->getReference($someOne['owner']));
            $manager->persist($animal);
            $this->addReference('animal_' . $key, $animal);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            SpeciesFixtures::class,
        ];
    }
}

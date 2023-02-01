<?php

namespace App\DataFixtures;

use app\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public const USERSDB = [
        [
            'email' => 'alain.dupont@caramail.com',
            'firstName' => 'Alain',
            'lastName' => 'Dupont',
            'address' => '259, rue du pont-neuf',
            'zipCode' => '74000',
            'city' => 'Annecy',
            'phoneNumber' => '0695124578',
        ],
        [
            'email' => 'anne.dubois@caramail.com',
            'firstName' => 'Anne',
            'lastName' => 'Dubois',
            'address' => '70, rue des vignes',
            'zipCode' => '74970',
            'city' => 'Meythet',
            'phoneNumber' => '0690104750',
        ],
        [
            'email' => 'eric.durand@caramail.com',
            'firstName' => 'Eric',
            'lastName' => 'Durand',
            'address' => '12, rue des sapins',
            'zipCode' => '74400',
            'city' => 'Chamonix-Mont-Blanc',
            'phoneNumber' => '0632152970',
        ],
        [
            'email' => 'emilie.pagnard@aramail.com',
            'firstName' => 'Emilie',
            'lastName' => 'Pagnard',
            'address' => '38, rue Pasteur',
            'zipCode' => '39000',
            'city' => 'Lons-Le-Saunier',
            'phoneNumber' => '0612131517',
        ],
        [
            'email' => 'lea.delarue@caramail.com',
            'firstName' => 'Léa',
            'lastName' => 'Delarue',
            'address' => '5, rue Gustave Effeil',
            'zipCode' => '73000',
            'city' => 'Chambery',
            'phoneNumber' => '0657462016',
        ],
        [
            'email' => 'paul.duclos@caramail.com',
            'firstName' => 'Paul',
            'lastName' => 'Duclos',
            'address' => '240, rue des cerisiers',
            'zipCode' => '01000',
            'city' => 'Bourg-en-Bresse',
            'phoneNumber' => '0632150176',
        ],

    ];

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERSDB as $key => $someOne) {
            $user = new user();
            $user -> setEmail($someOne['email']);
            $user -> setFirstName($someOne['firstName']);
            $user -> setLastName($someOne['lastName']);
            $user -> setAddress($someOne['address']);
            $user -> setZipcode($someOne['zipCode']);
            $user -> setCity($someOne['city']);
            $user -> setPhoneNumber($someOne['phoneNumber']);
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                'password'
            );
            $user -> setPassword($hashedPassword);
            $manager->persist($user);
            $this->addReference('user_' . $key, $user);
        }

        $manager->flush();
    }
}

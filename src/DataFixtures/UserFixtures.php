<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture
{

    /**
     * Permet d'encoder un mot de passe
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //1er Utilisateur en ADMIN

        $lastname = $faker->lastName();
        $firstname = $faker->firstName();
        $pseudo = $this->createPseudo($lastname, $firstname);

        $user = new User();
        $user->setEmail('olivier.clement88@hotmail.fr')
            ->setnom($lastname)
            ->setPrenom($firstname)
            ->setPseudo($pseudo)
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->encoder->encodePassword($user, 'admin'))
        ;
        $manager->persist($user);

        //creation de tout les autre utilisateur
        for ($i=0; $i < 100; $i++) {
            $lastname = $faker->lastName();
            $firstname = $faker->firstName();
            $pseudo = $this->createPseudo($lastname, $firstname);

            $user = new User();
            $user->setEmail($faker->email())
                ->setnom($lastname)
                ->setPrenom($firstname)
                ->setPseudo($pseudo)
                ->setPassword($this->encoder->encodePassword($user, 'password'))
            ;
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function createPseudo(string ...$concat): string
    {
        $pseudo = '';
        foreach ($concat as $key => $value) {
            $pseudo .= substr($value, 0, 3);
        }
        $pseudo = strtolower($pseudo);
        return $pseudo;
    }

}
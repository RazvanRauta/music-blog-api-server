<?php

/**
 * @author Razvan Rauta
 * 21.05.2019
 * 20:31
 */

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Song;
use App\Entity\User;
use App\Security\TokenGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var Factory
     */
    private $faker;

    /**
     * @var TokenGenerator
     */
    private $tokenGenerator;

    private const USERS = [
        [
            'username' => 'admin',
            'email' => 'admin@music-blog.com',
            'name' => 'Razvan Rauta',
            'password' => 'Secret123#',
            'roles' => [User::ROLE_SUPERADMIN],
        ],
        [
            'username' => 'john_doe',
            'email' => 'john@music-blog.com',
            'name' => 'John Doe',
            'password' => 'Secret123#',
            'roles' => [User::ROLE_ADMIN],
        ],
        [
            'username' => 'rob_smith',
            'email' => 'rob@music-blog.com',
            'name' => 'Rob Smith',
            'password' => 'Secret123#',
            'roles' => [User::ROLE_ADMIN],
        ],
        [
            'username' => 'jenny_rowling',
            'email' => 'jenny@music-blog.com',
            'name' => 'Jenny Rowling',
            'password' => 'Secret123#',
            'roles' => [User::ROLE_ADMIN],
        ],
        [
            'username' => 'han_solo',
            'email' => 'han@music-blog.com',
            'name' => 'Han Solo',
            'password' => 'Secret123#',
            'roles' => [User::ROLE_ADMIN],
        ],
        [
            'username' => 'jedi_knight',
            'email' => 'jedi@music-blog.com',
            'name' => 'Jedi Knight',
            'password' => 'Secret123#',
            'roles' => [User::ROLE_ADMIN],
        ]
    ];

    private const GENRES = [
        ['name' => 'Blues'],
        ['name' => 'Classical'],
        ['name' => 'Country'],
        ['name' => 'Electronic'],
        ['name' => 'Folk'],
        ['name' => 'Jazz'],
        ['name' => 'New age'],
        ['name' => 'Reggae'],
    ];

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TokenGenerator $tokenGenerator
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, TokenGenerator $tokenGenerator)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create();
        $this->tokenGenerator = $tokenGenerator;

    }


    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadGenres($manager);
        $this->loadSongs($manager);
    }


    public function loadUsers(ObjectManager $manager)
    {
        foreach (self::USERS as $userFixture) {
            $user = new User();
            $user->setUsername($userFixture['username']);
            $user->setEmail($userFixture['email']);
            $user->setName($userFixture['name']);

            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $userFixture['password']
                )
            );
            $user->setRoles($userFixture['roles']);

            $this->addReference('user_' . $userFixture['username'], $user);

            $manager->persist($user);
        }

        $manager->flush();
    }


    public function loadGenres(ObjectManager $manager)
    {

        foreach (self::GENRES as $genreFixture) {

            $genre = new Genre();
            $genre->setName($genreFixture['name']);

            $this->addReference('genre_' . $genreFixture['name'], $genre);

            $manager->persist($genre);
        }

        $manager->flush();
    }


    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function loadSongs(ObjectManager $manager)
    {

        for ($i = 0; $i < 100; $i++) {

            $song = new Song();

            $userReference = $this->getRandomUserReference($song);
            $genreReference = $this->getRandomGenreReference($song);


            $song->setTitle(ucwords(implode(' ', $this->faker->words(random_int(3, 6)))))
                ->setArtist($this->faker->firstName . ' ' . $this->faker->lastName)
                ->setPublished($this->faker->dateTimeThisYear)
                ->setDuration($this->faker->time('i:s', 'now'))
                ->setYear($this->faker->year('now'))
                ->setGenre($genreReference)
                ->setUser($userReference);


            $this->setReference("song_$i", $song);

            $manager->persist($song);
        }

        $manager->flush();
    }


    /**
     * @param $entity
     * @return User|object
     * @throws \Exception
     */
    protected function getRandomUserReference($entity)
    {
        $randomUser = self::USERS[random_int(0, 5)];

        if ($entity instanceof Song && !count(
                array_intersect(
                    $randomUser['roles'],
                    [User::ROLE_SUPERADMIN, User::ROLE_ADMIN]
                )
            )) {
            return $this->getRandomUserReference($entity);
        }


        return $this->getReference(
            'user_' . $randomUser['username']
        );
    }


    /**
     * @param $entity
     * @return Genre|object
     * @throws \Exception
     */
    protected function getRandomGenreReference($entity)
    {
        $randomGenre = self::GENRES[random_int(0, 7)];

//        if ($entity instanceof Song) {
//            return $this->getRandomGenreReference($entity);
//        }

        return $this->getReference(
            'genre_' . $randomGenre['name']
        );
    }
}

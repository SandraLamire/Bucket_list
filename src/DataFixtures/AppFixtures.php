<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Wish;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $managerRegistry;
    private $faker;
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
        $this->passwordHasher = $userPasswordHasher;
        $this->faker = Factory::create('fr FR');
    }

    public function load(ObjectManager $manager): void
    {
        $this->addCategory($manager);
        $this->addUser($this->passwordHasher,$manager);
        $this->addWish($manager);
    }


    public function addCategory(ObjectManager $manager)
    {
        $possibilities=["Travel & Adventure", "Sport", "Entertainment", "Human Relations", "Others"];

        for ($i=0; $i<sizeof($possibilities); $i++){
            $category = new Category();
            $category->setName(($possibilities[$i]));

            $manager->persist($category);
        }
        $manager->flush();
    }

    public function addUser(UserPasswordHasherInterface $passwordHasher, objectManager $manager){

        $admin = new User();
        $admin
            ->setPseudo("Admin")
            ->setEmail("admin@gmail.com")
            ->setPassword($passwordHasher->hashPassword($admin, "AdminMDP"))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        for ($i=0; $i<100; $i++) {
            $user = new User();
            $user
                ->setPseudo($this->faker->userName)
                ->setEmail($this->faker->email)
                ->setPassword($this->faker->password)
                ->setRoles(['ROLE_USER']);

            $manager->persist($user);
        }
        $manager->flush();
    }

    public function addWish(ObjectManager $manager)
    {
        $categoryRepo = new CategoryRepository($this->managerRegistry);
        $categories = $categoryRepo->findAll();

        for ($i=0; $i<100; $i++){
            $wish = new Wish();

            $wish
                ->setTitle($this->faker->sentence(6))
                ->setDescription($this->faker->sentence(150))
                ->setAuthor($this->faker->name)
                ->setDateCreated($this->faker->dateTimeBetween('-2years', 'now'))
                ->setCategory($this->faker->randomElement($categories));
            $manager->persist($wish);
        }
        $manager->flush();
    }
}

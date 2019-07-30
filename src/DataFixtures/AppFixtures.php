<?php
namespace App\DataFixtures;

use Faker;
use App\Entity\Beer;
use App\Entity\Country;
use App\Entity\Category;

use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        $countries = ['belgium', 'french', 'English', 'germany'];

        for ($i = 0; $i < 10; $i++) {
            $country = new Country();
            $country->setName($countries[rand(0,3)]);
            $country->setAddress($faker->address);
            $country->setEmail($faker->email);

            $manager->persist($country);
        }

        // créer effectivement les countries en base de données
        $manager->flush();

        // Category
        $categoriesNormales = ['blonde', 'brune', 'blanche'];
        foreach ($categoriesNormales as $title) {
            $category = new Category();
            $category->setTitle($title);
            $category->setTerm('normal');

            $manager->persist($category);
        }

        $categoriesSpeciales = ['houblon', 'rose', 'menthe', 'grenadine', 'réglisse', 'marron', 'whisky', 'bio'];
        foreach ($categoriesSpeciales as $title) {
            $category = new Category();
            $category->setTitle($title);
            $category->setTerm('special');

            $manager->persist($category);
        }

        // créer effectivement les categories en base de données
        $manager->flush();

        // select * from country => hydratation avec le model Country
        // doctrine retourne un array de Country (object entity)
        $repoCountry = $manager->getRepository(Country::class);
        $countries = $repoCountry->findAll();

        $categoryNormal = $manager->getRepository(Category::class);
        $categories = $categoryNormal->findByTerm('normal');

        $categoriesSpecials = $categoryNormal->findByTerm('special');

        for ($i = 0; $i < 20; $i++) {
            $beer = new Beer();
            $beer->setName($faker->word);
            // de manière aléatoire je prend un objet Country dans le repo de 0 à 2
            // setCountry <= tu dois lui passer un objet de type Country pour créer la relation entre
            // une bière et son pays.
            $beer->setCountry($countries[rand(0,2)]);
            $beer->setPrice($faker->randomNumber(2));
            $beer->setDescription($faker->paragraph(rand(2,8)));
            $beer->setPublishedAt($faker->dateTime());

            // associe une catégorie à une bière
            $beer->addCategory($categories[rand(0,2)]);

            // une bière peut par contre avoir plusieurs catégories spéciales associées
            shuffle($categoriesSpecials);
            
            $specials = array_slice($categoriesSpecials, 0, rand(1,4));
            foreach ($specials as $special)  {
                $beer->addCategory($special);
            }

            $manager->persist($beer);
        }

        $manager->flush();
    }
}
<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        $slugify = new Slugify();
        for ($i = 0; $i < 70; $i++)
        {
            $episode = new Episode();
            $episode->setTitle($faker->domainWord);
            $episode->setNumber($faker->randomDigit);
            $episode->setSynopsis($faker->text);
            $episode->setSlug($slugify->generate($faker->domainWord));
            $episode->setSeason($this->getReference('season_'.random_int(0,19)));
            $manager->persist($episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}
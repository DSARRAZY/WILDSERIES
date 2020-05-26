<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++)
        {
            $season = new Season();
            $season->setNumber($i);
            $season->setYear($faker->year);
            $season->setDescription($faker->text);
            $season->setProgram($this->getReference('program_'.random_int(0,4)));
            $this->addReference('season_' . $i, $season);
            $manager->persist($season);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}
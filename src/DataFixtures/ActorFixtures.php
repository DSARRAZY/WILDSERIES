<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Actor;
use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = [
        'Andrew Lincoln',
        'Norman Reedus',
        'Lauren Cohan',
        'Danai Gurira',
    ];

    public function load(ObjectManager $manager)
    {
        $slugify = new Slugify();
        foreach (self::ACTORS as $key => $actorName) {
            $actor = new Actor();
            $actor->setName($actorName);
            $actor->setSlug($slugify->generate($actorName));
            $manager->persist($actor);
            $actor->addProgram($this->getReference('program_0'));
        }

        $faker  =  Faker\Factory::create('fr_FR');
        $slugify = new Slugify();
        for ($i = 0; $i < 50; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name);
            $actor->setSlug($slugify->generate($faker->name));
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
            $actor->addProgram($this->getReference('program_'.random_int(0,4)));
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}
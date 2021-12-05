<?php

namespace App\DataFixtures;

use App\Entity\Season;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASONS = [
        'Saison 1' => [
            'program' => 'program_0',
            'number' => 1,
            'year' => 2010,
        ],
        'Saison 2' => [
            'program' => 'program_1',
            'number' => 2,
            'year' => 2011,
        ],
    ];


    public function load(ObjectManager $manager)
    {
        $i = 0;
        $slugify = new Slugify();
        foreach (self::SEASONS as $description => $data) {
            $season = new Season();
            $season->setDescription($description);
            $season->setProgram($this->getReference($data['program']));
            $season->setNumber($data['number']);
            $season->setYear($data['year']);
            $season->setSlug($slugify->generate($season->getDescription()));
            $manager->persist($season);
            $this->addReference('season_' . $i, $season);
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}

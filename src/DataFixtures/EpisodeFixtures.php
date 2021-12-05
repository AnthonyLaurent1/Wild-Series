<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const EPISODES = [
        'Episode 1' => [
            'season' => 'season_0',
            'number' => 1,
            'synopsis' => "C'est l'épisode 1",
        ],
        'Episode 2' => [
            'season' => 'season_0',
            'number' => 2,
            'synopsis' => "C'est l'épisode 2",
        ],
        'Episode 3' => [
            'season' => 'season_0',
            'number' => 3,
            'synopsis' => "C'est l'épisode 3",
        ],
        'Episode 4' => [
            'season' => 'season_0',
            'number' => 4,
            'synopsis' => "C'est l'épisode 4",
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $i = 0;
        foreach (self::EPISODES as $title => $data) {
            $episode = new Episode();
            $episode->setTitle($title);
            $episode->setSeason($this->getReference($data['season']));
            $episode->setNumber($data['number']);
            $episode->setSynopsis($data['synopsis']);
            $manager->persist($episode);
            $this->addReference('episode_' . $i, $episode);
            $i++;
        }
       $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}

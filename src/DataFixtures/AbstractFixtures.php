<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

abstract class AbstractFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * AbstractFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;

        $this->faker = Factory::create('fr_FR');
    }

    /**
     * @param $ref
     * @param $manager
     */
    public function doLoad($ref, $manager)
    {
        foreach ($ref as $key => $infos) {
            $obj = $this->buildObject($key, $infos);
            $manager->persist($obj);

            $ref[$key]['obj'] = $obj;
        }

        $manager->flush();

        foreach ($ref as $key => $infos) {
            $this->addReference($key, $infos['obj']);
        }
    }

    /**
     * @param $key
     * @param $infos
     * @return mixed
     */
    abstract function buildObject ($key, $infos);
}

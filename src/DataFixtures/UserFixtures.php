<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    const ADMIN_REFERENCE = 'admin@localhost';
    const USER1_REFERENCE = 'userOne@localhost';
    const USER2_REFERENCE = 'userTwo@localhost';

    public function load(ObjectManager $manager)
    {
        $ref = [
            self::ADMIN_REFERENCE => [
                'email' => self::ADMIN_REFERENCE,
                'pwd' => 'pwd',
                'roles' => ['ROLE_USER', 'ROLE_ADMIN'],
                'obj' => null
            ],
            self::USER1_REFERENCE => [
                'email' => self::USER1_REFERENCE,
                'pwd' => 'pwd',
                'roles' => ['ROLE_USER'],
                'cie' => $this->getReference(CompanyFixtures::CIE_ONE_REFERENCE),
                'obj' => null,
            ],
            self::USER2_REFERENCE => [
                'email' => self::USER2_REFERENCE,
                'pwd' => 'pwd',
                'roles' => ['ROLE_USER'],
                'cie' => $this->getReference(CompanyFixtures::CIE_TWO_REFERENCE),
                'obj' => null,
            ],
        ];

        $this->doLoad($ref, $manager);
    }

    function buildObject($key, $infos)
    {
        $obj = new User($this->passwordEncoder);
        $obj->setEmail($infos['email'])
            ->setPassword($this->passwordEncoder->encodePassword($obj, $infos['pwd']))
            ->setRoles($infos['roles']);

        if (array_key_exists('cie', $infos)) {
            $obj->setCompany($infos['cie']);
        }

        return $obj;
    }

    public function getDependencies()
    {
        return array(
            CompanyFixtures::class,
        );
    }
}

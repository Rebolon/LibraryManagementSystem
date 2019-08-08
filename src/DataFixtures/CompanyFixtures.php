<?php
namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Common\Persistence\ObjectManager;

class CompanyFixtures extends AbstractFixtures
{
    public const CIE_ONE_REFERENCE = 'company-one';
    public const CIE_TWO_REFERENCE = 'company-two';

    public function load(ObjectManager $manager)
    {
        $ref = [
            self::CIE_ONE_REFERENCE => [
                'name' => 'Bibliothèque des liseurs heureux',
                'obj' => null
            ],
            self::CIE_TWO_REFERENCE => [
                'name' => 'Dévoreurs de livres en vacances',
                'obj' => null,
            ],
        ];

        $this->doLoad($ref, $manager);
    }

    function buildObject($key, $infos)
    {
        $cie = new Company();
        $cie->setName($infos['name'])
            ->setEmail($this->faker->email)
            ->setPhone($this->faker->phoneNumber)
            ->setPostalAddress($this->faker->address)
            ->setPostCode($this->faker->postcode)
            ->setCity($this->faker->city)
            ->setCountry($this->faker->country)
            ->setActive(true);

        return $cie;
    }
}

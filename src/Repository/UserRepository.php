<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Retrieve a user based on its email, if the token is still valid
     *
     * @param $email
     * @param $token
     * @param UserPasswordEncoderInterface $encoder
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByEmailIfTokenIsValid($email, $token, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->andWhere('u.apiTokenTtl >= CURRENT_TIMESTAMP()')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
            ;

        if (!$user) {
            return null;
        }

        // to user isPAsswordValid i need a user whom password is the apiToken from our User
        // the other solution would be to re-implement isPasswordValid in a isApiTokenValid
        $userWithTokenAsPassword = new User();
        $userWithTokenAsPassword->setPassword($user->getApiToken());

        if (!$encoder->isPasswordValid($userWithTokenAsPassword, $token)) {
            return null;
        }

        return $user;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

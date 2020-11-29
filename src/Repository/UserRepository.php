<?php

namespace App\Repository;

use App\Entity\GiftsList;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findOneByUsername(string $username)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :val')
            ->setParameter('val', $username)
            ->getQuery()
            ->getResult()[0];
    }
    public function findOtherUsersNotSelected($currentUserId)
    {
        return $this->createQueryBuilder('u')
            ->where('u.id != :id')
            ->andWhere('u.isSelected = :isSelected')
            ->setParameter('id', $currentUserId)
            ->setParameter('isSelected', 0)
            ->getQuery()
            ->getResult();
    }

    public function findOneByHash(string $hash)
    {
        return $this->createQueryBuilder('u')
            ->andwhere('u.hash = :hash')
            ->setParameter('hash', $hash)
            ->getQuery()
            ->getResult();
    }

    public function findSelectedBy($user) {
        $result =  $this->createQueryBuilder('u')
            ->andWhere('u.selectedUser = :selectedUser')
            ->setParameter('selectedUser',  $user)
            ->getQuery()
            ->getResult();

        return !empty($result) ? $result[0] : $result;
    }

    public function findUsersNotSelected(string $currentUserFirstname)
    {
        return  $this->createQueryBuilder('u')
            ->where('u.selectedUser is null')
            ->andWhere('u.firstname != :userFirstname')
            ->setParameter('userFirstname', $currentUserFirstname)
            ->getQuery()
            ->getResult()[0];
    }
}

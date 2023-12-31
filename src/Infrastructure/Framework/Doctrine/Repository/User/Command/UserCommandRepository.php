<?php

declare(strict_types=1);

namespace App\Infrastructure\Framework\Doctrine\Repository\User\Command;

use App\Infrastructure\Framework\Doctrine\Entity\PersonEntity;
use App\Infrastructure\Framework\Doctrine\Entity\UserEntity;
use App\Infrastructure\Framework\Doctrine\Repository\AbstractRepository;
use App\Infrastructure\Framework\Doctrine\StorePersistEntityService;
use Doctrine\ORM\EntityManagerInterface;
use Domain\User\Domain\Model\User;
use Domain\User\Repository\Command\UserCommandRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserCommandRepository extends AbstractRepository implements UserCommandRepositoryInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected StorePersistEntityService $storePersistEntityService,
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {
        parent::__construct(
            $this->entityManager,
            $this->storePersistEntityService,
        );
    }

    public function register(User $user): void
    {
        $personEntity = new PersonEntity();
        $personEntity
            ->setFirstName($user->getPerson()->getFirstName())
            ->setLastName($user->getPerson()->getLastName())
            ->setBirthDate($user->getPerson()->getBirthDate());

        $userEntity = new UserEntity();
        $password = $this->userPasswordHasher->hashPassword($userEntity, $user->getPassword());

        $userEntity
            ->setPerson($personEntity)
            ->setEmail($user->getEmail())
            ->setPassword($password)
            ->setRoles($user->getRoles());

        $this->entityManager->persist($userEntity);
    }
}

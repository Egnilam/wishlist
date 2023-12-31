<?php

declare(strict_types=1);

namespace Domain\User\UseCase\Command;

use Domain\Common\Domain\Exception\EmailFormatException;
use Domain\Common\Domain\Exception\NameFormatException;
use Domain\Common\Domain\ValueObject\Email;
use Domain\Common\Domain\ValueObject\Name;
use Domain\Common\Service\IdServiceInterface;
use Domain\User\Domain\Enum\UserRoleEnum;
use Domain\User\Domain\Exception\UserRoleException;
use Domain\User\Domain\Model\User;
use Domain\User\Port\Command\RegisterUserInterface;
use Domain\User\Repository\Command\UserCommandRepositoryInterface;
use Domain\User\Request\RegisterUserRequest;

final readonly class RegisterUserUseCase implements RegisterUserInterface
{
    public function __construct(
        private UserCommandRepositoryInterface $userCommandRepository,
        private IdServiceInterface $idService,
    ) {
    }

    /**
     * @throws UserRoleException
     * @throws NameFormatException
     * @throws EmailFormatException
     */
    public function execute(RegisterUserRequest $request): void
    {
        $user = new User(
            $this->idService->next(),
            new Name($request->getFirstName(), Name::PROPERTY_FIRSTNAME),
            new Name($request->getLastName(), Name::PROPERTY_LASTNAME),
            new Email($request->getEmail()),
            $request->getPassword(),
            [UserRoleEnum::USER->value],
            $request->getBirthDate()
        );

        $this->userCommandRepository->register($user);
    }
}

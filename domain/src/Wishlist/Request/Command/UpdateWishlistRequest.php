<?php

declare(strict_types=1);

namespace Domain\Wishlist\Request\Command;

use Domain\Wishlist\Domain\Model\VisibilityEnum;

final readonly class UpdateWishlistRequest extends AbstractWishlistRequest
{
    public function __construct(
        private string         $id,
        private string         $wishlistMemberId,
        private string         $name,
        private VisibilityEnum $visibility,
    ) {
        parent::__construct(
            $this->wishlistMemberId,
            $this->name,
            $this->visibility
        );
    }

    public function getId(): string
    {
        return $this->id;
    }
}

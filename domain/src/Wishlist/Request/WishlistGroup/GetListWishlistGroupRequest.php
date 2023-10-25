<?php

declare(strict_types=1);

namespace Domain\Wishlist\Request\WishlistGroup;

final class GetListWishlistGroupRequest
{
    public function __construct(
        private ?string $wishlistMemberId = null,
        private bool $active = true,
    ) {

    }

    public function getWishlistMemberId(): ?string
    {
        return $this->wishlistMemberId;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
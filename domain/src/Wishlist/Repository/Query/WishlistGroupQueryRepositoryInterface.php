<?php

declare(strict_types=1);

namespace Domain\Wishlist\Repository\Query;

use Domain\Wishlist\Request\Query\WishlistGroup\GetListWishlistGroupRequest;
use Domain\Wishlist\Request\Query\WishlistGroup\GetWishlistGroupRequest;
use Domain\Wishlist\Response\WishlistGroupResponse;

interface WishlistGroupQueryRepositoryInterface
{
    public function get(GetWishlistGroupRequest $request): WishlistGroupResponse;

    /**
     * @return array<WishlistGroupResponse>
     */
    public function getList(GetListWishlistGroupRequest $request): array;
}

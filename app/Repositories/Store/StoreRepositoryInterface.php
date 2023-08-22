<?php

namespace App\Repositories\Store;

use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * The repository interface for the Store Model
 */
interface StoreRepositoryInterface extends RepositoryInterface
{
    /**
     * Paginating, ordering and searching through pages for server side index table for the API
     * @param array $searchParams
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringForApi(array $searchParams): LengthAwarePaginator;
}
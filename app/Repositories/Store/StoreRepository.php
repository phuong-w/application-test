<?php

namespace App\Repositories\Store;

use App\Models\Store;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

/**
 * The repository for Store Model
 */
class StoreRepository extends BaseRepository implements StoreRepositoryInterface
{
    /**
     * @inheritdoc
     */
    protected $model;

    const ITEM_PER_PAGE = 10;

    /**
     * @inheritdoc
     */
    public function __construct(Store $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    /**
     * @inheritdoc
     */
    public function create($data)
    {
        $data['user_id'] = auth()->id();

        return $this->model->create($data);
    }

    /**
     * @inheritdoc
     */
    public function update($model, $data)
    {
        $data['user_id'] = auth()->id();

        return $model->update($data);
    }

    /**
     * @inheritdoc
     */
    public function destroy($model)
    {
        if ($model->products) {
            $model->products()->delete();
        }

        return $model->delete();
    }

    /**
     * @inheritDoc
     */
    public function serverPaginationFilteringForApi($searchParams): LengthAwarePaginator
    {
        $limit = Arr::get($searchParams, 'limit', self::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'search', '');
        $storeId = Arr::get($searchParams, 'store_id', '');

        $query = $this->model->query();
        $query->where('user_id', auth()->id());

        if ($storeId) {
            $query->where('store_id', $storeId);
        }

        if ($keyword) {
            if (is_array($keyword)) {
                $keyword = $keyword['value'];
            }
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%');
            });
        }

        $query->latest();

        return $query->paginate($limit);
    }

    /**
     * @inheritDoc
     */
    public function find($id)
    {
        return $this->model->where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
    }
}
<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * The repository for Store Model
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * @inheritdoc
     */
    protected $model;

    const ITEM_PER_PAGE = 10;

    /**
     * @inheritdoc
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    /**
     * @inheritdoc
     */
    public function create($data)
    {
        $data['slug'] = $this->generateSlug($data['name']);
        $data['user_id'] = auth()->id();

        return $this->model->create($data);
    }

    /**
     * @inheritdoc
     */
    public function update($model, $data)
    {
        if (isset($data['name'])) {
            $data['slug'] = $this->generateSlug($data['name'], $model->id);
        }

        $data['user_id'] = auth()->id();

        return $model->update($data);
    }

    /**
     * Generate slug
     *
     * @param string $name
     */
    function generateSlug($name, $id = null)
    {
        $slug = Str::slug($name, '-');
        $checkSlug = $this->checkSlugExist($slug, $id);
        while ($checkSlug) {
            $slug = $slug . '-1';
            $checkSlug = $this->checkSlugExist($slug, $id);
        }
        return $slug;
    }

    /**
     * Check if the slug is existed
     *
     * @param String $slug
     * @param Integer $id
     * @return void
     */
    public function checkSlugExist($slug, $id = null)
    {
        return $this->model->where('id', '!=', $id)->where('slug', $slug)->first();
    }

    /**
     * @inheritDoc
     */
    public function serverPaginationFilteringForApi($searchParams): LengthAwarePaginator
    {
        $limit = Arr::get($searchParams, 'limit', self::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'search', '');

        $query = $this->model->query();
        $query->where('user_id', auth()->id());

        if ($keyword) {
            if (is_array($keyword)) {
                $keyword = $keyword['value'];
            }
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('slug', 'LIKE', '%' . $keyword . '%');
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
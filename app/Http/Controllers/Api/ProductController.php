<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Responses\JsonResponse;

/**
 * @group Product Endpoints
 *
 * APIs for managing product
 */
class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Get a list of products.
     *
     * This endpoint lets you get a list of products
     * @authenticated
     *
     * @queryParam store_id int The id of the store. Default get products all stores. No-example
     * @queryParam limit integer The number of resource that will show and then paginate. Example: 50
     * @queryParam search string The keyword for the name or the slug of the products. No-example
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->serverPaginationFilteringForApi($request->all());
        return ProductResource::collection($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Create the product of the current user
     * @authenticated
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        if ($product = $this->productRepository->create($request->validated())) {
            $product->load(['user', 'store']);
            return response()->json(new JsonResponse(new ProductResource($product)), Response::HTTP_OK);
        }

        return response()->json(new JsonResponse([], __('Create product fail.')), Response::HTTP_NOT_FOUND);
    }

    /**
     * Get the specific product by its slug.
     *
     * This endpoint lets you get the specific product by using its slug
     * @authenticated
     *
     * @urlParam slug string required The slug of the product.
     *
     * @apiResource App\Http\Resources\Api\ProductResource
     * @apiResourceModel App\Models\Product
     *
     * @return \Illuminate\Http\JsonResponse | ProductResource
     */
    public function show($slug)
    {
        $product = $this->productRepository->findBySlug($slug);
        if ($product) {
            $product->load(['user', 'store']);
            return new ProductResource($product);
        }
        return response()->json(new JsonResponse([], __('No product found.')), Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the product of the current user
     * @authenticated
     *
     * @urlParam product integer required The ID of the product.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $productId)
    {
        $product = $this->productRepository->find($productId);
        if ($product && $this->productRepository->update($product, $request->validated())) {
            $product->load(['user', 'store']);
            return response()->json(new JsonResponse(new ProductResource($product)), Response::HTTP_OK);
        }

        return response()->json(new JsonResponse([], __('Update product fail.')), Response::HTTP_NOT_FOUND);
    }

    /**
     * Delete the product of the current customer
     * @authenticated
     *
     * @urlParam product integer required The ID of the product.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId)
    {
        $product = $this->productRepository->find($productId);
        if ($product && $this->productRepository->destroy($product)) {
            return response()->json(new JsonResponse([
                'message' => __('Delete product successfully.')
            ]), Response::HTTP_OK);
        }

        return response()->json(new JsonResponse([], __('Delete product fail.')), Response::HTTP_NOT_FOUND);
    }
}

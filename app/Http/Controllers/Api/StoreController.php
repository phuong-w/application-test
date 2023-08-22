<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\CreateStoreRequest;
use App\Http\Requests\Store\UpdateStoreRequest;
use App\Http\Resources\Api\StoreResource;
use App\Repositories\Store\StoreRepositoryInterface;
use App\Responses\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Store Endpoints
 *
 * APIs for managing store
 */
class StoreController extends Controller
{
    private $storeRepository;

    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * Get a list of stores.
     *
     * This endpoint lets you get a list of stores
     * @authenticated
     *
     * @queryParam store_id int The id of the store. Default get products all stores. No-example
     * @queryParam limit integer The number of resource that will show and then paginate. Example: 50
     * @queryParam search string The keyword for the name of the stores. No-example
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $stores = $this->storeRepository->serverPaginationFilteringForApi($request->all());
        return StoreResource::collection($stores);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Create the store of the current user
     * @authenticated
     *
     * @bodyParam working_days int[] The working days of the store. No-example
     * <p>integer 1 to 7 for day</p>
     * <p>For 1: Sunday</p>
     * <p>For 2: Monday</p>
     * <p>For 3: Tuesday</p>
     * <p>For 4: Wednesday</p>
     * <p>For 5: Thursday</p>
     * <p>For 6: Friday</p>
     * <p>For 7: Saturday</p>
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStoreRequest $request)
    {
        if ($store = $this->storeRepository->create($request->validated())) {
            return response()->json(new JsonResponse(new StoreResource($store)), Response::HTTP_OK);
        }

        return response()->json(new JsonResponse([], __('Create store fail.')), Response::HTTP_NOT_FOUND);
    }

    /**
     * Get the specific store by its id.
     *
     * This endpoint lets you get the specific store by using its id
     * @authenticated
     *
     * @urlParam store_id int required The id of the store.
     *
     * @apiResource App\Http\Resources\Api\StoreResource
     * @apiResourceModel App\Models\Store
     *
     * @return \Illuminate\Http\JsonResponse | StoreResource
     */
    public function show($storeId)
    {
        $store = $this->storeRepository->find($storeId);
        if ($store) {
            $store->load(['user']);
            return new StoreResource($store);
        }
        return response()->json(new JsonResponse([], __('No store found.')), Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the store of the current user
     * @authenticated
     *
     * @urlParam store integer required The ID of the store.
     *
     * @bodyParam working_days int[] The working days of the store. No-example
     * <p>integer 1 to 7 for day</p>
     * <p>For 1: Sunday</p>
     * <p>For 2: Monday</p>
     * <p>For 3: Tuesday</p>
     * <p>For 4: Wednesday</p>
     * <p>For 5: Thursday</p>
     * <p>For 6: Friday</p>
     * <p>For 7: Saturday</p>
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStoreRequest $request, $storeId)
    {
        $store = $this->storeRepository->find($storeId);
        if ($store && $this->storeRepository->update($store, $request->validated())) {
            return response()->json(new JsonResponse(new StoreResource($store)), Response::HTTP_OK);
        }

        return response()->json(new JsonResponse([], __('Update store fail.')), Response::HTTP_NOT_FOUND);
    }

    /**
     * Delete the store of the current customer
     * @authenticated
     *
     * @urlParam store integer required The ID of the store.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($storeId)
    {
        $store = $this->storeRepository->find($storeId);
        if ($store && $this->storeRepository->destroy($store)) {
            return response()->json(new JsonResponse([
                'message' => __('Delete store successfully.')
            ]), Response::HTTP_OK);
        }

        return response()->json(new JsonResponse([], __('Delete store fail.')), Response::HTTP_NOT_FOUND);
    }
}

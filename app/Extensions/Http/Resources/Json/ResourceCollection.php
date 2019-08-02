<?php

namespace App\Extensions\Http\Resources\Json;


use App\Services\TranslationService;
use Illuminate\Http\Resources\CollectsResources;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Pagination\AbstractPaginator;
use IteratorAggregate;

class ResourceCollection extends JsonResource implements IteratorAggregate
{
    use CollectsResources;

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects;

    /**
     * The mapped collection instance.
     *
     * @var \Illuminate\Support\Collection
     */
    public $collection;

    /**
     * Create a new resource instance.
     *
     * @param  mixed $resource
     * @return void
     */
    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->resource = $this->collectResource($resource);
    }

    /**
     * Transform the resource into a JSON array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map->toArray($request)->all();
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        $resourceResponse = new PaginatedResourceResponse($this);
        $response = $this->resource instanceof AbstractPaginator
            ? $resourceResponse->toResponse($request)
            : parent::toResponse($request);

        if ($this->toTranslate) {
            $response->original = TranslationService::translate($response->original, $this->locales);
            $response = $this->resource instanceof AbstractPaginator
                ? $resourceResponse->toResponse($request)
                : parent::toResponse($request);
        }

        return $response;
    }

}

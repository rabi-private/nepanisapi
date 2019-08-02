<?php

namespace App\Extensions\Http\Resources\Json;

use App\Services\TranslationService;
use Illuminate\Http\Resources\Json\ResourceResponse;


class JsonResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    protected $toTranslate = false;
    protected $locales = null;

    /**
     * Translate the language data associated with the model.
     *
     * @param null $locale
     * @return $this
     */
    public function translate($locales = null)
    {
        $this->locales = $locales;
        $this->toTranslate = true;
        return $this;
    }

    /**
     * Translate to all the languages ​​defined by defined_locales.
     *
     * @param null $locale
     * @return $this|mixed
     */
    public function translateLocales()
    {
        return $this->translate(config('app.defined_locales'));
    }

    /**
     * Create new anonymous resource collection.
     *
     * @param  mixed $resource
     * @return \App\Extensions\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        return new AnonymousResourceCollection($resource, get_called_class());
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        $resourceResponse = (new ResourceResponse($this));
        $response = $resourceResponse->toResponse($request);

        if ($this->toTranslate) {
            $response->original = TranslationService::translate($response->original, $this->locales);
            $response = $this->resource instanceof AbstractPaginator
                ? $resourceResponse->toResponse($request)
                : parent::toResponse($request);
        }

        return $response;
    }
}

<?php

namespace App\Http\Controllers;

use App\Transformers\BaseTransformer;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;

/**
 * 系统控制器基础类
 * Class Controller
 * @package App\Http\Controllers
 */
class AppController extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * response to the no content
     * User: long
     * Date: 2020/5/2 2:26 PM
     * Describe:
     * @return JsonResponse
     */
    public function noContent() : JsonResponse
    {
        return response()->json([], 204);
    }

    /**
     * response to the array
     * User: long
     * Date: 2020/5/2 2:26 PM
     * Describe:
     * @param mixed $object
     * @return JsonResponse
     */
    public function responseArray($object) : JsonResponse
    {
        return response()->json($object);
    }

    /**
     * response to the item
     * User: long
     * Date: 2020/5/2 2:28 PM
     * Describe:
     * @param mixed $object
     * @param BaseTransformer $Transformer
     * @return JsonResponse
     */
    public function responseItem($object, BaseTransformer $Transformer) : JsonResponse
    {
        $response = (new Manager())
            ->createData(new Item($object, $Transformer))
            ->toArray();

        return response()->json($response['data'], 200);
    }

    /**
     * response to the collection
     * User: long
     * Date: 2020/5/2 2:07 PM
     * Describe:
     * @param mixed $object
     * @param BaseTransformer $Transformer
     * @param array $meta
     * @return JsonResponse
     */
    public function responseCollection($object, BaseTransformer $Transformer, array $meta = []) : JsonResponse
    {
        $resource = (new Collection($object, $Transformer))->setMeta($meta);

        $response = (new Manager())->createData($resource)->toArray();

        return response()->json($response, 200);
    }

    /**
     * response to the paginator
     * User: long
     * Date: 2020/5/2 2:06 PM
     * Describe:
     * @param LengthAwarePaginator | \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
     * @param BaseTransformer $transformer
     * @param array $meta
     * @return JsonResponse
     */
    public function responsePaginate(LengthAwarePaginator $paginator, BaseTransformer $transformer, array $meta = []) : JsonResponse
    {
        $resource = (new Collection($paginator->getCollection(), $transformer))
            ->setPaginator(new IlluminatePaginatorAdapter($paginator))
            ->setMeta($meta);

        $response = (new Manager())->createData($resource)->toArray();

        return response()->json($response, 200);
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  array  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateWithArray(
        array $request, array $rules, array $messages = [], array $customAttributes = []
    ) {
        return $this->getValidationFactory()->make(
            $request, $rules, $messages, $customAttributes
        )->validate();
    }

}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;

class ResourceController extends Controller
{
    /**
     * List a resource within a pagination envelope.
     *
     * @param  App\Contracts\Model\ListableInterface $resource
     * @param  Request           $request
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function listResource(ListableInterface $resource, Request $request)
    {
        $numberResults = (int) $request->get('limit', 50);

        return $resource->list()->paginate($numberResults);
    }

    /**
     * Show a resource.
     *
     * @param  App\Contracts\Model\ShowableInterface $resource
     * @return App\Contracts\Model\ShowableInterface
     */
    public function showResource(ShowableInterface $resource)
    {
        return $resource->show()->first();
    }
}

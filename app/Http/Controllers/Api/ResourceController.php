<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;

class ResourceController extends Controller
{
    /**
     * List a resource within a pagination envelope.
     *
     * @param  Illuminate\Database\Eloquent\Model $resource
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function listResource(Model $resource, Request $request)
    {
        if (! $resource instanceof ListableInterface) {
            abort(404);
        }

        $numberResults = (int) $request->get('limit', 50);

        return $resource->list()->paginate($numberResults);
    }

    /**
     * Show a resource.
     *
     * @param  Illuminate\Database\Eloquent\Model $resource
     * @param  int $id
     * @return App\Contracts\Model\ShowableInterface
     */
    public function showResource(Model $resource, $id)
    {
        if (! $resource instanceof ShowableInterface) {
            abort(404);
        }

        return $resource->where('id', $id)->show()->first();
    }
}

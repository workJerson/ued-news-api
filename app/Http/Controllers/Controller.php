<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="U-ED News API Documentation",
     *      description="A simple API made with Laravel 8",
     *      @OA\Contact(
     *          email="work.jerson.baltazar@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )
     */

    /**
         @OAS\SecurityScheme(
             securityScheme="bearerAuth",
            type="http",
            scheme="bearer"
        )
     **/
    protected function generateCachedResponse($callback)
    {
        // TODO: For refactor.
        return $callback();

        $params = request()->query();
        ksort($params);
        $rememberKey = sha1(request()->url().http_build_query($params));
    }

    protected function paginateOrGet($builder)
    {
        if (request()->has('page')) {
            return $builder->paginate(request('per_page'));
        }

        if ($builder instanceof \Illuminate\Support\Collection) {
            return $builder->values();
        }

        return $builder->get();
    }

    /**
     * Switch to CMS or WEB equivalent function.
     *
     * @param mixed $request
     * @param mixed $model
     *
     * @return Function
     */
    protected function switch(string $method, $request = null, $model = null)
    {
        if (request()->user()->is_cms ?? false) {
            $method .= 'Cms';
        } else {
            $method .= 'Web';
        }

        return $this->$method($request, $model);
    }

    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    protected function resourceAbilityMap()
    {
        return [
            'index' => 'view',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
        ];
    }
}

<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //$this->configureRateLimiting();

        $this->routes(function () {
            foreach (File::allFiles(base_path('app/Containers')) as $file) {
                $filename = $file->getFilename();

                if($filename == 'web.php') {
                    Route::middleware('web')
                        ->namespace($this->namespace)
                        ->group($file->getPath() . '/' . $filename);
                }

                if($filename == 'api.php') {
                    Route::prefix('api')
                        ->middleware('api')
                        ->namespace($this->namespace)
                        ->group($file->getPath() . '/' . $filename);
                }
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    // protected function configureRateLimiting()
    // {
    //     RateLimiter::for('api', function (Request $request) {
    //         return Limit::perMinute(60)->by($request->ip())->response(function (Request $request, array $headers) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'msg' => 'Превышен лимит отправки запросов'
    //             ], 200, $headers);
    //         });
    //     });
    // }
}

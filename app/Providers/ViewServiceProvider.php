<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerContainers();

        Blade::componentNamespace('App\\Containers\\Pages\\UI\\WEB\\Views\\pages\\profile\\components', 'profile');
    }

    public function registerContainers($section_name = '')
    {
        $base_path = 'app/Containers/' . $section_name;

        $iterator = new \DirectoryIterator(base_path($base_path));
        foreach ($iterator as $fileinfo) {
            if ($fileinfo->isDot()) continue;

            $directory_name = $fileinfo->getFilename();
            if(strpos($directory_name, 'Section')) {
                $this->registerContainers($section_name . $directory_name . '/');
                continue;
            }

            $container_name = $directory_name;
            $path = base_path($base_path . $container_name . '/UI/WEB/Views');
            if(file_exists($path)) {
                $arr = explode('/', $section_name . $container_name);
                $namespace_name = mb_strtolower(implode('.', $arr));
                View::addNamespace($namespace_name, $path);
            }
        }
    }
}

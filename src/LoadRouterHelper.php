<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl;

use App\Models\Callcocam\AccessGroup;
use App\Models\Callcocam\Permission;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class LoadRouterHelper
{

    /**
     * @var array
     */
    private $ignore = ['auth', 'store', 'remove-file', 'auto-route', 'translate', 'profile'];

    /**
     * @var array
     */
    private $required = ['admin', 'app', 'index', 'edit', 'list', 'show', 'create', 'destroy', 'delete'];


    public static function make()
    {

        $make = new static();

        return $make;
    }


    public  function save($delete = false)
    {
        if ($delete) {
            Permission::query()->forceDelete();
        }

        foreach (Route::getRoutes() as $route) {

            if (isset($route->action['as'])) :
                $permission = $route->action['as'];
                $data = explode(".", $permission);

                if ($this->getIgnore($data)) :

                    if ($this->getRequired($data)) :

                        $permissionFormated = Str::of($permission)->lower()
                            ->replace("pages.", "")
                            ->replace("resources.", "")
                            ->replace('filament.', '')->__toString();
                        if (!Permission::query()->where('slug', $permissionFormated)->count()) {
                            $description = Str::of($permissionFormated)->lower()->replace(".", " ")->__toString();
                            $name = Str::of($permissionFormated)->lower()->__toString();
                            $name  = Str::title(str_replace(".", " ", $name));
                            $last = Arr::last($data);
                            if (!in_array($last, ['edit', 'create', 'view', 'show',  'destroy', 'delete'])) {
                                $last = "index";
                            }
                            if ($group = AccessGroup::query()->where('slug', $last)->first()) :
                                $last = $group->id;
                            else :
                                $last = AccessGroup::create([
                                    'name' => $last,
                                    'slug' => $last,
                                    'status' => 'published',
                                    'description' => $last
                                ])->id;
                            endif;
                            Permission::create(
                                [
                                    'name' => $name,
                                    'slug' => $permissionFormated,
                                    'access_group_id' => $last,
                                    'status' => 'published',
                                    'description' => $description
                                ]
                            );
                        }
                    endif;

                endif;

            endif;
        }
    }


    public function getRoutes()
    {
        $options = [];

        foreach (Route::getRoutes() as $route) {

            if (isset($route->action['as'])) :

                $data = explode(".", $route->action['as']);

                if ($this->getIgnore($data)) :

                    if ($this->getRequired($data)) :
                        if (!in_array($route->action['as'], $options)) {
                            $permission = $route->action['as'];
                            $description = Str::of($permission)->lower()->replace(".", " ")->__toString();
                            $name = Str::of($permission)->lower()->replace('filament.', '')->__toString();
                            $name  = Str::title(str_replace(".", " ", $name));
                            $last = Arr::last($data);
                            if (!in_array($last, ['edit', 'create', 'view', 'show', 'index', 'list', 'destroy', 'delete'])) {
                                $last = "index";
                            }
                            array_push($options, [
                                'name' => $name,
                                'slug' => $route->action['as'],
                                'group' => $last,
                                'status' => 'published',
                                'description' => $description
                            ]);
                        }
                    endif;

                endif;

            endif;
        }
        return $options;
    }
    private function getIgnore($value)
    {

        $result = true;

        foreach ($this->ignore as $item) {

            if (in_array($item, $value)) {

                $result = false;
            }
        }

        return $result;
    }


    private function getRequired($value)
    {

        $result = false;

        foreach ($this->required as $item) {

            if (in_array($item, $value)) {

                $result = true;
            }
        }

        return $result;
    }
}

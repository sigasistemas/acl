<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Resources\RoleResource\Pages;

use Filament\Forms\Components\Section;

trait ExtraRoleTrait
{
    protected static function getExtraFieldsSchemaForm($record,  $contents = [])
    {

        if (class_exists('App\Core\Helpers\RoleHelper')) {
            if (method_exists(app('App\Core\Helpers\RoleHelper'), 'getExtrafileds')) {
                $extras = app('App\Core\Helpers\RoleHelper')->getExtrafileds($record);
                foreach ($extras as $extra) {
                    $content =   Section::make(data_get($extra, 'name'))
                        ->description(data_get($extra, 'description')) 
                        ->collapsed(data_get($extra, 'collapsed', false))
                        ->schema(function () use ($extra) {
                            $contents_ = [];
                            if ($fields = data_get($extra, 'fields')) {
                                foreach ($fields as $field) {
                                    $contents_[] = $field;
                                }
                            }
                            return $contents_;
                        });
                    $contents[] = $content;
                }
            }
        }

        return  $contents;
    }
}

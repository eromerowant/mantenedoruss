<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('exists_soft', function($attribute, $value, $parameters){
            if (!isset($parameters[0])) {
                throw new \Exception('Validator "exists_soft" missing tablename.');
            }
            $tableName = $parameters[0];
            $columnName = isset($parameters[1])?$parameters[1]:null;
            $validator = Validator::make([$attribute => $value],
            [
                $attribute => [
                    Rule::exists($tableName, $columnName)
                        ->where(function ($query) {
                        $query->whereNull('deleted_at');
                    }),
                ]
            ]);
            return $validator->passes();
        });
    }
}

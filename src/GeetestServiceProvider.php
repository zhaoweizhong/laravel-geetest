<?php

namespace Zhaoweizhong\Geetest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class GeetestServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // 发布配置文件
        $this->publishes([
            __DIR__.'/../config/laravel-geetest.php' => config_path('laravel-geetest.php'),
        ]);
        // 扩展验证规则
        Validator::extend('geetest', 'Zhaoweizhong\Geetest\Validators\GeetestValidator@validate');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('geetest', function ($app) {
            return $app->make('Zhaoweizhong\Geetest\Libs\GeetestLib');
        });
    }
}
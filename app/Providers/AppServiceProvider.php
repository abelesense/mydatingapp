<?php
namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Добавляем слушатель события входа
        Event::listen(Login::class, function () {
            if (!Session::has('first_login')) {
                // Очищаем просмотренные ID пользователей в сессии при первом входе
                Session::forget('viewed_user_ids');
                Session::put('first_login', true); // Устанавливаем флаг, чтобы избежать очистки на следующих входах
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

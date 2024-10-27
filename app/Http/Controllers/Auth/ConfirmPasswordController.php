<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Контроллер подтверждения пароля
    |--------------------------------------------------------------------------
    |
    | Этот контроллер отвечает за обработку подтверждений паролей и использует
    | трейт, который добавляет соответствующее поведение. Ты можешь изменить
    | функции в этом трейте, если потребуется.
    |
    */

    use ConfirmsPasswords;

    /**
     * Куда перенаправлять пользователей, если подтверждение не удалось.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Перенаправление на домашнюю страницу в случае неудачи

    /**
     * Создание нового экземпляра контроллера.
     *
     * @return void
     */
    public function __construct()
    {
        // Применение middleware для проверки аутентификации пользователя
        $this->middleware('auth'); // Только авторизованные пользователи могут подтверждать пароль
    }
}
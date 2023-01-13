<?php


namespace App\Http\Controllers\Api\Core;


use App\Http\Controllers\Controller;
use App\Http\Requests\Core\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller

{
    /**
     * Регистрация пользователь в API
     *
     *
     * @group Учетная запись
     * @bodyParam name string required Имя пользователя. Example: Иван
     * @bodyParam second_name string Фамилия пользователя. Example: Иванов
     * @bodyParam last_name string Отчество пользователя. Example: Иванович
     * @bodyParam email email required Почтовый адрес пользователя. Example: test@test.ru
     * @bodyParam password string required Пароль пользователя. Example: 123123
     * @bodyParam c_password string required Повтор пароля. Example: 123123
     * @return JsonResponse
     */

    public function register(RegisterRequest $request)

    {
        $request->validated();

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken($user->email)->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User register successfully.');

    }


    /**
     * Авторизация пользователь в API
     *
     *
     * @group Учетная запись
     * @bodyParam email email required Почтовый адрес пользователя. Example: example@ge-world.ru
     * @bodyParam password string required Пароль пользователя. Example: 123123
     * @return JsonResponse
     */

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();
            $success['token'] = $user->createToken($user->email)->plainTextToken;
            $success['name'] = $user->name;
            return $this->sendResponse($success, 'Успешная авторизация');

        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

}

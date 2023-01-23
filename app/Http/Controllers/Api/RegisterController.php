<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Settings;
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
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken($user->email)->plainTextToken;
        $success['name'] = $user->name;
        $user_id = $user->id;

        $data = $this->setUserSettings($user_id);

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
            $success['initials'] = getUserInitials($user->name, $user->last_name,$user->second_name);
            $success['dark'] = $user->setting()->get()[0]['dark_mode'];
            return $this->sendResponse($success, 'Успешная авторизация');

        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

    }

    private function setUserSettings($user_id)
    {
        $income = [1,2,3,4,5,6,7];

        $expend = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32];

        Settings::create([
            'user_id' => $user_id,
            'income_category_main' => json_encode($income),
            "income_category_active" => json_encode($income),
            "expend_category_main" => json_encode($expend),
            "expend_category_active" => json_encode($expend)
        ]);

        return true;
    }

}

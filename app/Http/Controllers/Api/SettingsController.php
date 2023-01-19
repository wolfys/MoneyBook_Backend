<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsRequest;
use App\Http\Resources\SettingsResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SettingsController extends Controller
{

    /**
     * Получить все настройки пользователя.
     *
     * @group Настройки
     * @authenticated
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $data = auth()->user()->setting()->get();

        return SettingsResource::collection($data);
    }

    /**
     * Изменить настройки пользователя.
     *
     * @group Настройки
     * @bodyParam balance_credit_card_full int required Баланс кредитной карты. Example: 120000
     * @bodyParam expend_category_main json required Включенные категории расхода на главной странице. Example: [1, 2, 3, 6]
     * @bodyParam income_category_main json required Включенные категории дохода на главной странице. Example: [1, 2, 3, 6]
     * @bodyParam expend_category_active json required Активный категории расхода. Example: [1, 2, 3, 6]
     * @bodyParam income_category_active json required ЗАктивный категории дохода. Example: [1, 2, 3, 6]
     * @authenticated
     * @return JsonResponse
     */
    public function update(SettingsRequest $request)
    {
        $request->validated();

        $data = auth()->user()->setting()->get();

        $arr = [];

        foreach ($data as $value) {
            $arr['balance_credit_card_full'] = ($request->get('balance_credit_card_full')) ?
                $request->get('balance_credit_card_full') : $value->balance_credit_card_full;
            $arr['expend_category_main'] = ($request->get('expend_category_main')) ?
                $request->get('expend_category_main') : $value->expend_category_main;
            $arr['income_category_main'] = ($request->get('income_category_main')) ?
                $request->get('income_category_main') : $value->income_category_main;
            $arr['expend_category_active'] = ($request->get('expend_category_active')) ?
                $request->get('expend_category_active') : $value->expend_category_active;
            $arr['income_category_active'] = ($request->get('income_category_active')) ?
                $request->get('income_category_active') : $value->income_category_active;
            $arr['dark_mode'] = ($request->get('dark_mode') !== null) ? $request->get('dark_mode') :
                $value->dark_mode;
        }

        auth()->user()->setting()->update($arr);

        return $this->sendResponseDataNull('Настройки успешно изменены');
    }
}

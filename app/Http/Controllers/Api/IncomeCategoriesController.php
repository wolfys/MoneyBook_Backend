<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Http\Resources\CategoriesResource;
use App\Models\IncomeCategories;
use Illuminate\Http\JsonResponse;

class IncomeCategoriesController extends Controller
{


    /**
     * Получить все категории доступные пользователю.
     *
     * @group Доходы
     * @subgroup Категории
     * @authenticated
     * @return JsonResponse
     */
    public function index()
    {
        $data = IncomeCategories::where('user_id', '=', null)
            ->orWhere('user_id', '=', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->get();

        return $this->sendResponse(CategoriesResource::collection($data),
            'Возвращаем справочник Категории доходов');
    }

    /**
     * Получить категории дохода выбранные пользователем.
     *
     * @group Доходы
     * @subgroup Категории
     * @authenticated
     * @return JsonResponse
     */
    public function indexUserCategory()
    {

        $userSettingData = json_decode(auth()->user()->setting()->first()->income_category_active);


        $data = IncomeCategories::whereIn('id', $userSettingData)
            ->orderBy('name', 'asc')
            ->get();

        return $this->sendResponse(CategoriesResource::collection($data),
            'Возвращаем справочник Категории доходов');
    }

    /**
     * Добавить категорию доходов.
     *
     * @bodyParam name string required Название категории. Example: Лотерея
     * @group Доходы
     * @subgroup Категории
     * @authenticated
     * @return JsonResponse
     */
    public function store(CategoriesRequest $request)
    {
        IncomeCategories::create([
            'user_id' => auth()->user()->id,
            'name' => $request->get('name')
        ]);

        return $this->sendResponseDataNull('Новый пункт в Справочник Категория доходов успешно добавлен');

    }


    /**
     * Поиск категории доходов для редактирования.
     *
     * Можно искать только категории который, создал пользователь.
     *
     * @urlParam id int required ID категории доходов для поиска. Example: 8
     * @group Доходы
     * @subgroup Категории
     * @authenticated
     * @return JsonResponse
     */
    public function show($id)
    {
        $data = IncomeCategories::where('id', '=', $id)->first();

       checkUsers($data,'income-categories');

        return $this->sendResponse(new CategoriesResource($data),
            "Запись {$id} в Категория доходов найдена");
    }

    /**
     * Изменить категорию доходов.
     *
     * Можно редактировать только категории который, создал пользователь.
     *
     * @urlParam id int required ID категории доходов для поиска. Example: 8
     * @bodyParam name string required Название категории. Example: Нашёл на улице
     * @group Доходы
     * @subgroup Категории
     * @authenticated
     * @return JsonResponse
     */
    public function update(CategoriesRequest $request, $id)
    {
        checkUsers(IncomeCategories::where('id', '=', $id)->first(),'income-categories');

        IncomeCategories::where('id', '=', $id)->update([
            'user_id' => auth()->user()->id,
            'name' => $request->get('name')
        ]);

        return $this->sendResponseDataNull('Справочник Категория доходов успешно обновлен');
    }

    /**
     * Удалить категорию доходов.
     *
     * Можно удалять только категории который, создал пользователь.
     *
     * @urlParam id int required ID категории доходов для поиска. Example: 8
     * @group Доходы
     * @subgroup Категории
     * @authenticated
     * @return JsonResponse
     */
    public function destroy($id)
    {
        checkUsers(IncomeCategories::where('id', '=', $id)->first(),'income-categories');

        IncomeCategories::where('id', '=', $id)->delete();

        return $this->sendResponseDataNull('Пункт в справочнике категория доходов успешно удален');
    }

}

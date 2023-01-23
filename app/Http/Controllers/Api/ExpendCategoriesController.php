<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Http\Resources\CategoriesResource;
use App\Models\ExpendCategories;
use Illuminate\Http\JsonResponse;

class ExpendCategoriesController extends Controller
{


    /**
     * Получить все категории доступные пользователю.
     *
     * @group Расходы
     * @subgroup Категории
     * @authenticated
     * @return JsonResponse
     */
    public function index()
    {
        $data = ExpendCategories::where('user_id', '=', null)
            ->orWhere('user_id', '=', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->get();

        return $this->sendResponse(CategoriesResource::collection($data),
            'Возвращаем справочник Категории расходов');
    }

    /**
     * Получить категории расхода выбранные пользователем.
     *
     * @group Расходы
     * @subgroup Категории
     * @authenticated
     * @return JsonResponse
     */
    public function indexUserCategory()
    {

        $userSettingData = json_decode(auth()->user()->setting()->first()->expend_category_active);

        $data = ExpendCategories::whereIn('id', $userSettingData)
            ->orderBy('name', 'asc')
            ->get();

        return $this->sendResponse(CategoriesResource::collection($data),
            'Возвращаем справочник Категории расходов');
    }

    /**
     * Добавить категорию расходов.
     *
     * @bodyParam name string required Название категории. Example: Шоколадки
     * @group Расходы
     * @subgroup Категории
     * @authenticated
     * @return JsonResponse
     */
    public function store(CategoriesRequest $request)
    {
        ExpendCategories::create([
            'user_id' => auth()->user()->id,
            'name' => $request->get('name')
        ]);

        return $this->sendResponseDataNull('Новый пункт в Справочник Категория расходов успешно добавлен');

    }


    /**
     * Поиск категории расходов для редактирования.
     *
     * Можно искать только категории который, создал пользователь.
     *
     * @urlParam id int required ID категории расходов для поиска. Example: 33
     * @group Расходы
     * @subgroup Категории
     * @authenticated
     * @return JsonResponse
     */
    public function show($id)
    {
        $data = ExpendCategories::where('id', '=', $id)->first();

        checkUsers($data,'expend-categories');

        return $this->sendResponse(new CategoriesResource($data),
            "Запись {$id} в Категория расходов найдена");
    }

    /**
     * Изменить категорию расходов.
     *
     * Можно редактировать только категории который, создал пользователь.
     *
     * @urlParam id int required ID категории расходов для поиска. Example: 33
     * @bodyParam name string required Название категории. Example: Шоколадки
     * @group  Расходы
     * @subgroup Категории
     * @authenticated
     * @return JsonResponse
     */
    public function update(CategoriesRequest $request, $id)
    {
        checkUsers(ExpendCategories::where('id', '=', $id)->first(),'expend-categories');

        ExpendCategories::where('id', '=', $id)->update([
            'user_id' => auth()->user()->id,
            'name' => $request->get('name')
        ]);

        return $this->sendResponseDataNull('Справочник Категория расходов успешно обновлен');
    }

    /**
     * Удалить категорию расходов.
     *
     * Можно удалять только категории который, создал пользователь.
     *
     * @urlParam id int required ID категории расходов для поиска. Example: 33
     * @group Расходы
     * @subgroup Категории
     * @authenticated
     * @return JsonResponse
     */
    public function destroy($id)
    {
        checkUsers(\App\Models\ExpendCategories::where('id', '=', $id)->first(),'expend-categories');

        \App\Models\ExpendCategories::where('id', '=', $id)->delete();

        return $this->sendResponseDataNull('Пункт в справочнике категория расходов успешно удален');
    }
}

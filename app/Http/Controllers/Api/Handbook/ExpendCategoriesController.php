<?php

namespace App\Http\Controllers\Api\Handbook;

use App\Http\Controllers\Controller;
use App\Http\Requests\Handbook\CategoriesRequest;
use App\Http\Resources\Handbook\CategoriesResource;
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
        $request->validated();

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
        $request->validated();

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

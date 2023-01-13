<?php

namespace App\Http\Controllers\Api\Handbook;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ExpendCategoriesRequest;
use App\Http\Resources\Handbook\ExpendCategoriesResource;
use App\Models\Handbook\ExpendCategories;
use Gate;
use Illuminate\Http\JsonResponse;

class ExpendCategoriesController extends BaseController
{


    /**
     * Получить все категории доступные пользователю.
     *
     * @group Справочники
     * @subgroup Категории Расходов
     * @authenticated
     * @return JsonResponse
     */
    public function index()
    {
        $data = ExpendCategories::where('user_id','=',null)
            ->orWhere('user_id','=', auth()->user()->id)
            ->get();

        return $this->sendResponse(ExpendCategoriesResource::collection($data),
            'Возвращаем справочник Категории расходов');
    }

    /**
     * Добавить категорию расходов.
     *
     * @bodyParam name string required Название категории. Example: Шоколадки
     * @group Справочники
     * @subgroup Категории Расходов
     * @authenticated
     * @return JsonResponse
     */
    public function store(ExpendCategoriesRequest $request)
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
     * @group Справочники
     * @subgroup Категории Расходов
     * @authenticated
     * @return JsonResponse
     */
    public function show($id)
    {

        if(ExpendCategories::find($id) === null || !Gate::allows('update-categories', ExpendCategories::find($id))) {
            return $this->sendError('Пункт не найден или его редактирование запрещено.');
        }

        $data = ExpendCategories::where('id', '=', $id)->first();


        return $this->sendResponse(new ExpendCategoriesResource($data),
            "Запись {$id} в Категория расходов найдена");
    }

    /**
     * Изменить категорию расходов.
     *
     * Можно редактировать только категории который, создал пользователь.
     *
     * @urlParam id int required ID категории расходов для поиска. Example: 33
     * @bodyParam name string required Название категории. Example: Шоколадки
     * @group Справочники
     * @subgroup Категории Расходов
     * @authenticated
     * @return JsonResponse
     */
    public function update(ExpendCategoriesRequest $request, $id)
    {
        $request->validated();

        if(ExpendCategories::find($id) === null || !Gate::allows('update-categories', ExpendCategories::find($id))) {
            return $this->sendError('Пункт не найден или его редактирование запрещено.');
        }

        ExpendCategories::where('id','=', $id)->update([
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
     * @group Справочники
     * @subgroup Категории Расходов
     * @authenticated
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if(ExpendCategories::find($id) === null || !Gate::allows('update-categories', ExpendCategories::find($id))) {
            return $this->sendError('Пункт не найден или его редактирование запрещено.');
        }


        ExpendCategories::where('id','=', $id)->delete();

        return $this->sendResponseDataNull('Пункт в справочнике категория расходов успешно удален');
    }
}

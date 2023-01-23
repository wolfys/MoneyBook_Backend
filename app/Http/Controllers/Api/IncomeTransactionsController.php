<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTransactionsRequest;
use App\Http\Requests\TransactionsRequest;
use App\Http\Resources\TransactionsResource;
use App\Models\IncomeTransactions;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class IncomeTransactionsController extends Controller
{
    /**
     * Получить все транзакции по доходам доступные пользователю за определенный период.
     *
     * @group Доходы
     * @subgroup Транзакции
     * @bodyParam start_date date required Дата начала периода. Example: 13.01.2023
     * @bodyParam end_date date required Дата начала окончания периода. Example: 13.01.2023
     * @authenticated
     * @return JsonResponse
     */
    public function index(IndexTransactionsRequest $request)
    {
        $start_date = Carbon::parse($request->get('start_date'))->format('Y-m-d 00:00:00');
        $end_date = Carbon::parse($request->get('end_date'))->format('Y-m-d 23:59:59');

        $data = auth()->user()->incomeTransactions()
            ->select('*','income_category_id as category_id')
            ->whereDate('date_transaction', '>=', $start_date)
            ->whereDate('date_transaction', '<=', $end_date)
            ->with('category','user')
            ->get();

        return $this->sendResponse(TransactionsResource::collection($data),'Получаем список доходов');
    }

    /**
     * Добавить новую транзакцию по доходам.
     *
     * @group Доходы
     * @subgroup Транзакции
     * @bodyParam category_id int required Категория доходов. Example: 1
     * @bodyParam money int required Кол-во затраченных средств. Example: 500
     * @bodyParam date_transaction date required Дата поступления средств. Example: 13.01.2023
     * @bodyParam comment string Комментарий к поступлению. Example: Доход от просмотра рекламы.
     * @bodyParam credit boolean required Затраты были ли с кредитной карты. Example: 1
     * @authenticated
     * @return JsonResponse
     */
    public function store(TransactionsRequest $request)
    {
        IncomeTransactions::create([
           'user_id' => auth()->user()->id,
           'income_category_id' => $request->get('category_id'),
            'money' => $request->get('money'),
            'comment' => $request->get('comment'),
            'date_transaction' => Carbon::parse($request->get('date_transaction'))->toDateTime(),
            'credit' => $request->get('credit')
        ]);

        return $this->sendResponseDataNull('Запись о доходах успешно добавлена');
    }

    /**
     * Поиск записи о доходах.
     *
     * @group Доходы
     * @subgroup Транзакции
     * @urlParam id int required ID записи дохода для поиска. Example: 1
     * @authenticated
     * @return JsonResponse
     */
    public function show($id)
    {

        $data = IncomeTransactions::where('id', '=', $id)
            ->select('*','income_category_id as category_id')
            ->with('category','user')->first();

        checkUsers($data,'income-transactions');

        return $this->sendResponse(new TransactionsResource($data),
            "Запись {$id} в транзакциях доходов найдена");
    }

    /**
     * Изменить запись транзакции по доходам.
     *
     * @group Доходы
     * @subgroup Транзакции
     * @urlParam id int required ID записи дохода для поиска. Example: 1
     * @bodyParam category_id int required Категория доходов. Example: 1
     * @bodyParam money int required Кол-во затраченных средств. Example: 500
     * @bodyParam date_transaction date required Дата поступления средств. Example: 13.01.2023
     * @bodyParam comment string Комментарий к поступлению. Example: Доход от просмотра рекламы.
     * @bodyParam credit boolean required Затраты были ли с кредитной карты. Example: 1
     * @authenticated
     * @return JsonResponse
     */
    public function update(TransactionsRequest $request, $id)
    {
        checkUsers(IncomeTransactions::where('id', '=', $id)->first(),'income-transactions');

        IncomeTransactions::where('id', '=', $id)->update([
            'income_category_id' => $request->get('category_id'),
            'money' => $request->get('money'),
            'comment' => $request->get('comment'),
            'date_transaction' => Carbon::parse($request->get('date_transaction'))->toDateTime(),
            'credit' => $request->get('credit')
        ]);

        return $this->sendResponseDataNull('Запись о доходах успешно изменена');
    }

    /**
     * Удалить записи о доходах.
     *
     * @group Доходы
     * @subgroup Транзакции
     * @urlParam id int required ID записи дохода для поиска. Example: 1
     * @authenticated
     * @return JsonResponse
     */
    public function destroy($id)
    {
        checkUsers(IncomeTransactions::where('id', '=', $id)->first(),'income-transactions');

        IncomeTransactions::where('id', '=', $id)->delete();

        return $this->sendResponseDataNull('Запись о доходах успешно удалена');
    }
}

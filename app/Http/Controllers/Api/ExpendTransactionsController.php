<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTransactionsRequest;
use App\Http\Requests\TransactionsRequest;
use App\Http\Resources\TransactionsResource;
use App\Models\ExpendTransactions;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class ExpendTransactionsController extends Controller
{
    /**
     * Получить все транзакции по расходам доступные пользователю за определенный период.
     *
     * @group Расходы
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



        $data = auth()->user()->expendTransactions()
            ->select('*','expend_category_id as category_id')
            ->whereDate('date_transaction', '>=', $start_date)
            ->whereDate('date_transaction', '<=', $end_date)
            ->with('category','user')
            ->orderBy('date_transaction','desc')
            ->get();

        return $this->sendResponse(TransactionsResource::collection($data),'Получаем список расходов');
    }

    /**
     * Добавить новую транзакцию по расходам.
     *
     * @group Расходы
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
        ExpendTransactions::create([
           'user_id' => auth()->user()->id,
           'expend_category_id' => $request->get('category_id'),
            'money' => $request->get('money'),
            'comment' => $request->get('comment'),
            'date_transaction' => Carbon::parse($request->get('date_transaction'))->toDateTime(),
            'credit' => $request->get('credit')
        ]);

        return $this->sendResponseDataNull('Запись о расходах успешно добавлена');
    }

    /**
     * Поиск записи о расходах.
     *
     * @group Расходы
     * @subgroup Транзакции
     * @urlParam id int required ID записи дохода для поиска. Example: 1
     * @authenticated
     * @return JsonResponse
     */
    public function show($id)
    {

        $data = ExpendTransactions::where('id', '=', $id)
            ->with('category','user')
            ->select('*','expend_category_id as category_id')
            ->first();

        checkUsers($data,'expend-transactions');

        return $this->sendResponse(new TransactionsResource($data),
            "Запись {$id} в транзакциях расходов найдена");
    }

    /**
     * Изменить запись транзакции по расходам.
     *
     * @group Расходы
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
        checkUsers(ExpendTransactions::where('id', '=', $id)->first(),'expend-transactions');

        ExpendTransactions::where('id', '=', $id)->update([
            'expend_category_id' => $request->get('category_id'),
            'money' => $request->get('money'),
            'comment' => $request->get('comment'),
            'date_transaction' => Carbon::parse($request->get('date_transaction'))->toDateTime(),
            'credit' => $request->get('credit')
        ]);

        return $this->sendResponseDataNull('Запись о расходах успешно изменена');
    }

    /**
     * Удалить записи о доходах.
     *
     * @group Расходы
     * @subgroup Транзакции
     * @urlParam id int required ID записи дохода для поиска. Example: 1
     * @authenticated
     * @return JsonResponse
     */
    public function destroy($id)
    {
        checkUsers(ExpendTransactions::where('id', '=', $id)->first(),'expend-transactions');

        ExpendTransactions::where('id', '=', $id)->delete();

        return $this->sendResponseDataNull('Запись о расходах успешно удалена');
    }
}

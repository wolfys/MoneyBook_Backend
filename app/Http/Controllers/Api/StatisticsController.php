<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatisticRequest;
use App\Http\Resources\StatisticsCategoryResource;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    /**
     * Получить полную текущую статистику авторизованного пользователя.
     *
     * @group Статистика
     * @authenticated
     * @return JsonResponse
     */
    public function getGeneralInformation()
    {
        $data = [
          'balance' => $this->formatNumber($this->getBalance()),
          'bank' => $this->formatNumber($this->getBalanceBank()),
          'credit' => $this->getBalanceCredit(),
        ];

        return $this->sendResponse($data, 'Текущий баланс пользователя');
    }

    /**
     * Получить статистику за выбранный период определенного вида транзакций.
     *
     * @urlParam type string required Тип транзакций (expend, income). Example: expend
     * @bodyParam start date required Дата начала периода. Example: 01.01.2023
     * @bodyParam end date required Дата окончания периода. Example: 31.12.2023
     * @group Статистика
     * @authenticated
     * @return JsonResponse
     */
    public function getTypeTransactionInCategory(StatisticRequest $request, $type) {

        $request->validated();

        if($type !== 'income' && $type !== 'expend')
        {
            return $this->sendError('Тип должен быть указан корректно');
        }

        $data = auth()->user();

        $data = ($type === 'income') ? $data->incomeTransactions() : $data->expendTransactions();

        $field = ($type === 'income') ? 'income_category_id' : 'expend_category_id';

        $start_date = Carbon::parse($request->get('start'))->format('Y-m-d 00:00:00');
        $end_date = Carbon::parse($request->get('end'))->format('Y-m-d 23:59:59');

        $data = $data
            ->select(\DB::raw("SUM(money), {$field} as category_id"))
            ->whereDate('date_transaction', '>=', $start_date)
            ->whereDate('date_transaction', '<=', $end_date)
            ->groupBy($field)
            ->get();

        return $this->sendResponse(StatisticsCategoryResource::collection($data), 'баланс пользователя за выбранный период');
    }

    /**
     * Получить статистику авторизованного пользователя за текущий месяц.
     *
     * @group Статистика
     * @bodyParam start date required Дата начала периода. Example: 01.01.2023
     * @bodyParam end date required Дата окончания периода. Example: 31.12.2023
     * @authenticated
     * @return JsonResponse
     */
    public function getStatisticPeriod(StatisticRequest $request)
    {

        $request->validated();

        $start_date = Carbon::parse($request->get('start'))->format('Y-m-d 00:00:00');
        $end_date = Carbon::parse($request->get('end'))->format('Y-m-d 23:59:59');

        $income = auth()
            ->user()
            ->incomeTransactions()
            ->whereDate('date_transaction', '>=', $start_date)
            ->whereDate('date_transaction', '<=', $end_date)
            ->sum('money');

        $expend = auth()
            ->user()
            ->expendTransactions()
            ->whereDate('date_transaction', '>=', $start_date)
            ->whereDate('date_transaction', '<=', $end_date)
            ->where('credit','=', false)
            ->sum('money');

        $balance = $income - $expend;

        $data = [
            'income' => $this->formatNumber($income),
            'expend' => $this->formatNumber($expend),
            'balance' => $this->formatNumber($balance)
        ];

        return $this->sendResponse($data, 'баланс пользователя за выбранный период');
    }


    private function formatNumber($data) {

        return  number_format($data, 0, '', ' ');
    }


    private function getBalance()
    {
        $expend = auth()
            ->user()
            ->expendTransactions()
            ->where('credit','=', false)
            ->sum('money');

        $income = auth()
            ->user()
            ->incomeTransactions()
            ->sum('money');

        return (int)$income - (int)$expend;
    }

    private function getBalanceBank()
    {
        $expend = auth()
            ->user()
            ->expendTransactions()
            ->where('expend_category_id','=',29)
            ->sum('money');

        $income = auth()
            ->user()
            ->incomeTransactions()
            ->where('income_category_id','=',6)
            ->sum('money');

        return (int)$expend - (int)$income;
    }

    private function getBalanceCredit()
    {
        $creditBalance = auth()->user()->setting()->first()->balance_credit_card_full;

        $expend = auth()
            ->user()
            ->expendTransactions()
            ->where('credit','=', true)
            ->sum('money');

        $income = auth()
            ->user()
            ->expendTransactions()
            ->where('expend_category_id','=', 14)
            ->sum('money');


       return [
           'debt' => $this->formatNumber($expend - $income),
           'balance' => $this->formatNumber($creditBalance - $expend + $income)
       ];
    }
}

<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Payment\TransactionRequest;
use App\Services\Base\TransactionService;
use Illuminate\Http\JsonResponse;

class TransactionsController extends BaseController
{
    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the transactions.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $transactions = $this->transactionService->getTransactionList();

        return $this->ok($transactions, __('Transactions retrieved successfully'));
    }

    /**
     * Store a newly created transaction in storage.
     *
     * @param TransactionRequest $request
     * @return JsonResponse
     */
    public function store(TransactionRequest $request): JsonResponse
    {
        $item = $this->transactionService->createTransaction($request->validated());

        if ($item) {
            return $this->created($item, __('Transaction created successfully'));
        }

        return $this->validationWarning([], __('We could not charge payment. Please, try again later!'));
    }
}

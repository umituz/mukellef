<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Payment\TransactionRequest;
use App\Models\User;
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
     * @param User $user
     * @return JsonResponse
     */
    public function index(User $user): JsonResponse
    {
        $transactions = $this->transactionService->getTransactionList($user->id);

        return $this->ok($transactions, __('Transactions retrieved successfully'));
    }

    /**
     * Store a newly created transaction in storage.
     *
     * @param User $user
     * @param TransactionRequest $request
     * @return JsonResponse
     */
    public function store(User $user, TransactionRequest $request): JsonResponse
    {
        $item = $this->transactionService->createTransaction([
            'user_id' => $user->id,
            'subscription_id' => $request->subscription_id,
            'price' => $request->price,
        ]);

        if ($item) {
            return $this->created($item, __('Transaction created successfully'));
        }

        return $this->validationWarning([], __('We could not charge payment. Please, try again later!'));
    }
}

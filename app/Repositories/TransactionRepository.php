<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

/**
 * Class TransactionRepository
 */
class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    private Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);

        $this->transaction = $transaction;
    }

    /**
     * @return mixed
     */
    public function getUserTransactionList()
    {
        return Auth::user()->transactions()->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createUserTransaction($data)
    {
        return Auth::user()->transactions()->create($data);
    }
}

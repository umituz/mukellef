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
     * @param $userId
     * @return mixed
     */
    public function getUserTransactionList($userId)
    {
        return $this->transaction->where('user_id', $userId)->get();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createUserTransaction($data)
    {
        return $this->transaction->create($data);
    }
}

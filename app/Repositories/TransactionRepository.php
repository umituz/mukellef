<?php

namespace App\Repositories;

use App\Models\Transaction;

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
    public function getUserTransactionList($userId)
    {
        return $this->transaction->where('user_id', $userId)->get();
    }

    /**
     * @return mixed
     */
    public function createUserTransaction($data)
    {
        return $this->transaction->create($data);
    }
}

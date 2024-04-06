<?php

namespace App\Repositories;

/**
 * Interface TransactionRepositoryInterface
 */
interface TransactionRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getUserTransactionList($userId);

    /**
     * @return mixed
     */
    public function createUserTransaction($data);
}

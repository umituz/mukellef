<?php

namespace App\Repositories;

/**
 * Interface TransactionRepositoryInterface
 */
interface TransactionRepositoryInterface
{
    /**
     * @param $userId
     * @return mixed
     */
    public function getUserTransactionList($userId);

    /**
     * @param $data
     * @return mixed
     */
    public function createUserTransaction($data);
}

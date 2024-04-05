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
    public function getUserTransactionList();

    /**
     * @param $data
     * @return mixed
     */
    public function createUserTransaction($data);
}

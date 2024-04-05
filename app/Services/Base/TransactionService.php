<?php

namespace App\Services\Base;

use App\Events\PaymentReceivedEvent;
use App\Http\Resources\TransactionResource;
use App\Repositories\TransactionRepositoryInterface;
use App\Services\Mail\MailService;
use Illuminate\Support\Facades\Auth;

class TransactionService
{
    private TransactionRepositoryInterface $transactionRepository;
    private MailService $mailService;

    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        MailService $mailService
    )
    {
        $this->transactionRepository = $transactionRepository;
        $this->mailService = $mailService;
    }

    public function getTransactionList()
    {
        $transactions = $this->transactionRepository->getUserTransactionList();

        return TransactionResource::collection($transactions);
    }

    public function createTransaction($validatedData)
    {
        $item = $this->transactionRepository->createUserTransaction([
            'subscription_id' => $validatedData['subscription_id'],
            'price' => $validatedData['price'],
        ]);

        $this->sendPaymentReceivedMail();

        return new TransactionResource($item);
    }

    private function sendPaymentReceivedMail()
    {
        $this->mailService->sendMailByEvent(
            PaymentReceivedEvent::class,
            Auth::user()
        );
    }
}

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
    private PaymentService $paymentService;

    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        MailService $mailService,
        PaymentService $paymentService
    )
    {
        $this->transactionRepository = $transactionRepository;
        $this->mailService = $mailService;
        $this->paymentService = $paymentService;
    }

    public function getTransactionList($userId)
    {
        $transactions = $this->transactionRepository->getUserTransactionList($userId);

        return TransactionResource::collection($transactions);
    }

    public function createTransaction($data)
    {
        $item = $this->payByProvider($data);

        if ($item === false) {
            return null;
        }

        return new TransactionResource($item);
    }

    private function payByProvider($data)
    {
        $paymentSuccess = $this->paymentService->pay($data['user_id'], $data['price']);

        if ($paymentSuccess) {
            $item = $this->transactionRepository->createUserTransaction([
                'user_id' => $data['user_id'],
                'subscription_id' => $data['subscription_id'],
                'price' => $data['price'],
            ]);

            $this->sendPaymentReceivedMail();

            return $item;
        } else {
            return false;
        }
    }

    private function sendPaymentReceivedMail()
    {
        $this->mailService->sendMailByEvent(
            PaymentReceivedEvent::class,
            Auth::user()
        );
    }
}

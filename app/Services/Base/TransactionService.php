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

    public function getTransactionList()
    {
        $transactions = $this->transactionRepository->getUserTransactionList();

        return TransactionResource::collection($transactions);
    }

    public function createTransaction($validatedData)
    {
        $item = $this->payByProvider(Auth::user(), $validatedData);

        if ($item === false) {
            return null;
        }

        return new TransactionResource($item);
    }

    private function payByProvider($user, $data)
    {
        $paymentSuccess = $this->paymentService->pay($user, $data['price']);

        if ($paymentSuccess) {
            $item = $this->transactionRepository->createUserTransaction([
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

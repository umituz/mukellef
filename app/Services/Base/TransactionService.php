<?php

namespace App\Services\Base;

use App\Events\PaymentReceivedEvent;
use App\Http\Resources\TransactionResource;
use App\Repositories\TransactionRepositoryInterface;
use App\Services\Mail\MailService;

class TransactionService
{
    private TransactionRepositoryInterface $transactionRepository;

    private MailService $mailService;

    private PaymentService $paymentService;

    private UserService $userService;

    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        MailService $mailService,
        PaymentService $paymentService,
        UserService $userService,
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->mailService = $mailService;
        $this->paymentService = $paymentService;
        $this->userService = $userService;
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
        $user = $this->userService->find($data['user_id']);
        $paymentSuccess = $this->paymentService->pay($user, $data['price']);

        if ($paymentSuccess) {
            $item = $this->transactionRepository->createUserTransaction([
                'user_id' => $data['user_id'],
                'subscription_id' => $data['subscription_id'],
                'price' => $data['price'],
            ]);

            $this->sendPaymentReceivedMail($user);

            return $item;
        } else {
            return false;
        }
    }

    private function sendPaymentReceivedMail($user)
    {
        $this->mailService->sendMailByEvent(
            PaymentReceivedEvent::class,
            $user
        );
    }
}

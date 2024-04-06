<?php

namespace Tests\Unit\Adapters;

use App\Adapters\StripeAdapter;
use Tests\BaseTestCase;

class StripeAdapterTest extends BaseTestCase
{
    public function test_should_return_true_when_paying_by_stripe()
    {
        $stripeAdapter = new StripeAdapter();
        $amount = 100;

        $result = $stripeAdapter->pay($amount);

        $this->assertTrue($result);
    }
}

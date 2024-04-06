<?php

namespace Tests\Unit\Adapters;

use App\Adapters\IyzicoAdapter;
use Tests\BaseTestCase;

class IyzicoAdapterTest extends BaseTestCase
{
    public function test_should_return_true_when_paying_by_iyzico()
    {
        $iyzicoAdapter = new IyzicoAdapter();
        $amount = 100;

        $result = $iyzicoAdapter->pay($amount);

        $this->assertTrue($result);
    }
}

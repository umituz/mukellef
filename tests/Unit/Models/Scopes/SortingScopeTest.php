<?php

namespace Tests\Unit\Models\Scopes;

use App\Models\User;
use Tests\BaseTestCase;

class SortingScopeTest extends BaseTestCase
{

    public function test_should_order_results_by_descending_id()
    {
        $first = User::factory()->create();
        $second = User::factory()->create();
        $third = User::factory()->create();

        $models = User::all();

        $this->assertTrue($models->first()->id === $third->id);

        $expectedOrder = [$third->id, $second->id, $first->id];
        $actualOrder = $models->pluck('id')->all();
        $this->assertEquals($expectedOrder, $actualOrder);
    }
}

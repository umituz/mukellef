<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Class IntegrationBaseTestCase
 */
class IntegrationBaseTestCase extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
}

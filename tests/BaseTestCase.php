<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * Class BaseTestCase
 */
class BaseTestCase extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
}

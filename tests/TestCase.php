<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function reservationShowStructure(): array
    {
        return [
            'id',
            'start_at',
            'end_at',
            'description',
            'created_at',
            'updated_at',
        ];
    }
}

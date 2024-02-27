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
            'user' => $this->userStructure(),
            'created_at',
            'updated_at',
        ];
    }

    protected function meStructure(): array
    {
        return [
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ];
    }

    protected function userStructure(): array
    {
        return [
            'name',
            'email',
        ];
    }
}

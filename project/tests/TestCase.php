<?php

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Sign in a user and mark the session as POPIA-acknowledged for direct-auth tests.
     */
    public function actingAs(Authenticatable $user, $guard = null)
    {
        $this->withSession(['popia_acknowledged' => true]);

        return parent::actingAs($user, $guard);
    }
}

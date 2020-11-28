<?php

namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserApiTest extends PassportTestCase
{
    /**
     * /api/userに対し、認証Tokenありでリクエストするテスト
     */
    public function testGetApiUserWithTokenInHeaders()
    {
        $this->get('/api/user', $this->headersWithToken)->assertStatus(200);
    }
    /**
     * /api/userに対し、認証Tokenなしでリクエストするテスト
     */
    public function testGetApiUserWithOutTokenInHeaders()
    {
        $this->get('/api/user', $this->headersWithoutToken)->assertStatus(401);
    }
}

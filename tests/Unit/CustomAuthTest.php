<?php

namespace Tests\Unit;

use App\Actions\Auth\CustomAuth;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class CustomAuthTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticateOnRedirectedUrl(): void
    {
        $user = User::factory()->create();
        $redirectUrl = 'https://' . config('app.domain.dashboard') . '/';
        $requestUrl = 'https://' . config('app.domain.auth') . '/?redirect=' . urlencode($redirectUrl);
        $mockRequest = Request::create($requestUrl, 'GET');
        $mockRequest->setUserResolver(fn() => $user);

        $redirectResponse = CustomAuth::authenticateOnRedirectedUrl($mockRequest, $redirectUrl);
        $this->assertEquals(302, $redirectResponse->getStatusCode());
    }
}

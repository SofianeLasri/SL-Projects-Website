<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController as FortifyPasswordResetLinkController;

class PasswordResetLinkController extends FortifyPasswordResetLinkController
{
    /**
     * Send a reset link to the given user.
     */
    public function store(Request $request): Responsable
    {
        $request->validate([Fortify::email() => 'required|email']);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = $this->broker()->sendResetLink(
            $request->only(Fortify::email())
        );

        // We don't want to reveal whether or not a user exists.
        if ($status == Password::RESET_LINK_SENT) {
            $status = Password::RESET_LINK_SENT;
        } else {
            $status = Password::RESET_LINK_SENT;
        }

        return app(SuccessfulPasswordResetLinkRequestResponse::class, ['status' => $status]);
    }
}

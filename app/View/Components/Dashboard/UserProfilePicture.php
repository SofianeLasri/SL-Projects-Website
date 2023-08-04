<?php

namespace App\View\Components\Dashboard;

use App\Models\User;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserProfilePicture extends Component
{
    private User $user;

    private string $userProfilPic;

    public function __construct(User $user = null)
    {
        if (empty($user)) {
            $this->user = Auth::user();
        } else {
            $this->user = $user;
        }
        $this->userProfilPic = '';
        // TODO : Terminer ce composant lorsque nous aurons terminé la gestion des images.
    }

    public function render(): View
    {
        return view('components.dashboard.user-profile-picture');
    }
}

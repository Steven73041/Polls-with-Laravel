<?php


namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use App\Log;
use App\User;

class LogFailedAuthenticationAttempt {
    /**
     * Handle the event.
     *
     * @param Failed $event
     * @return void
     */
    public function handle(Failed $event) {

        $user = User::find($event->user->id);

        Log::create([
            'action' => 'Αποτυχία σύνδεση χρήστη: '.$user->email,
            'user_id' => $user->id,
        ]);
    }

}

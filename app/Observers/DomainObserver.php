<?php

namespace App\Observers;

use Auth;
use App\Models\Domain;
use App\Notifications\DomainNotification;
use Illuminate\Support\Facades\Notification;

class DomainObserver
{
    /**
     * Handle the domain "created" event.
     *
     * @param  \App\Domain  $domain
     * @return void
     */
    public function created(Domain $domain)
    {
        Notification::route('slack', env('SLACK_HOOK'))->notify(
            new DomainNotification(
                $domain, 
                Auth::user(),
                'Create'
            )
        );
    }

    /**
     * Handle the domain "updated" event.
     *
     * @param  \App\Domain  $domain
     * @return void
     */
    public function updated(Domain $domain)
    {
        //
    }

    /**
     * Handle the domain "deleted" event.
     *
     * @param  \App\Domain  $domain
     * @return void
     */
    public function deleted(Domain $domain)
    {
        Notification::route('slack', env('SLACK_HOOK'))->notify(
            new DomainNotification(
                $domain, 
                Auth::user(),
                'Delete'
            )
        );
    }

    /**
     * Handle the domain "restored" event.
     *
     * @param  \App\Domain  $domain
     * @return void
     */
    public function restored(Domain $domain)
    {

    }

    /**
     * Handle the domain "force deleted" event.
     *
     * @param  \App\Domain  $domain
     * @return void
     */
    public function forceDeleted(Domain $domain)
    {

    }
}

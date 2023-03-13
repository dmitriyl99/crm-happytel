<?php

namespace App\Observers;

use App\Models\PaymentAction;
use App\Models\Provider;

class ProviderObserver
{
    /**
     * Handle the Provider "created" event.
     *
     * @param  \App\Models\Provider  $provider
     * @return void
     */
    public function created(Provider $provider)
    {
     
//         if(request()->payment){
//             $fee = str_replace(' ','',request()->payment);
//             PaymentAction::create([
//                 'fee' => $fee,
//                 'provider_id' => $provider->id,
//                 'comment' => 'Баланс заполнен',
//                 'type' => 'entry',
//                 'action' => 'provider'
//             ]);
//         }
    }

    /**
     * Handle the Provider "updated" event.
     *
     * @param  \App\Models\Provider  $provider
     * @return void
     */
    public function updated(Provider $provider)
    {
//         if(request()->payment){
            
//             $fee = str_replace(' ','',request()->payment);
   
//             PaymentAction::create([
//                 'fee' => $fee,
//                 'provider_id' => $provider->id,
//                 'message' => 'Баланс заполнен',
//                 'type' => 'entry',
//                 'action' => 'provider'
//             ]);
//         }
    }

    /**
     * Handle the Provider "deleted" event.
     *
     * @param  \App\Models\Provider  $provider
     * @return void
     */
    public function deleted(Provider $provider)
    {
        //
    }

    /**
     * Handle the Provider "restored" event.
     *
     * @param  \App\Models\Provider  $provider
     * @return void
     */
    public function restored(Provider $provider)
    {
        //
    }

    /**
     * Handle the Provider "force deleted" event.
     *
     * @param  \App\Models\Provider  $provider
     * @return void
     */
    public function forceDeleted(Provider $provider)
    {
        //
    }
}

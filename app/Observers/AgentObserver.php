<?php

namespace App\Observers;

use App\Models\Agent;
use App\Models\PaymentAction;
use Illuminate\Support\Facades\Config;

class AgentObserver
{
    /**
     * Handle the Agent "created" event.
     *
     * @param  \App\Models\Agent  $agent
     * @return void
     */
    public function created(Agent $agent)
    {
        /*if($agent->balance){
            PaymentAction::create([
                'fee' => $agent->balance,
                'agent_id' => $agent->id,
                'type' => 'entry',
                'message' => 'balance_filled',
                'user_id' => auth()->user()->id
            ]);
        }*/
        
    }

    /**
     * Handle the Agent "updated" event.
     *
     * @param  \App\Models\Agent  $agent
     * @return void
     */
    public function updated(Agent $agent)
    {
        /*if($agent->isDirty('balance')){
            PaymentAction::create([
                'fee' => $agent->balance - $agent->getOriginal('balance'),
                'agent_id' => $agent->id,
                'type' => 'entry',
                'message' => config('a_status.balance_filled') ?? 'Баланс заполнен',
                'user_id' => auth()->user()->id
            ]);

            // notification
            $notificationParams = [
                'user_id' => auth()->user()->id,
                'agent_id' => $agent->id,
                'message' => (config('a_status.balance_filled') ?? 'Баланс заполнен').' '.($agent->balance - $agent->getOriginal('balance')).' UZS',
            ];
        }*/
        
    }

    /**
     * Handle the Agent "deleted" event.
     *
     * @param  \App\Models\Agent  $agent
     * @return void
     */
    public function deleted(Agent $agent)
    {
        //
    }

    /**
     * Handle the Agent "restored" event.
     *
     * @param  \App\Models\Agent  $agent
     * @return void
     */
    public function restored(Agent $agent)
    {
        //
    }

    /**
     * Handle the Agent "force deleted" event.
     *
     * @param  \App\Models\Agent  $agent
     * @return void
     */
    public function forceDeleted(Agent $agent)
    {
        //
    }
}

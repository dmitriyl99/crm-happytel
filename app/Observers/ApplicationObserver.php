<?php

namespace App\Observers;

use App\Models\Agent;
use App\Models\Simcard;
use App\Models\Provider;
use App\Models\Application;
use App\Models\Notification;
use App\Models\PaymentAction;
use Illuminate\Support\Facades\Config;

class ApplicationObserver
{

    public function creating(Application $application)
    {
        $agent = Agent::where('id', $application->agent_id)->first();
        if(config('a_settings.limit_balance') != 0 && $agent->balance < config('a_settings.limit_balance')){
            session()->flash('error','Your balance less then limit. Пожалуйста, пополните баланс');
            return false;
        }
        if ($agent->balance - $application->plan->price_sell < 0) {
            session()->flash('error','Недостаточный баланс! Пожалуйста, пополните баланс');
            return false;
        }
    }

    /**
     * Handle the Application "created" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function created(Application $application)
    {
       
        $agent = Agent::where('id',$application->agent_id)->first();
        
        $agent->update([
            'balance' => $agent->balance - $application->plan->price_sell,
        ]);
        

        $provider = Provider::where('id',$application->plan->provider_id)->first();
        $provider->update([
            'balance' => $provider->balance - $application->plan->price_arrival
        ]);
        
        $simcard = Simcard::where('id', $application->simcard_id)->first();
        $simcard->update(['status' => 'active']);

        // payment
        $paymentParams = [
            'type' => 'exit',
            'agent_id' => auth()->user()->agent_id,
            'simcard_id' => $application->simcard_id,
            'fee' =>  $application->plan->price_sell,
            'message' => Config::get('a_status')['buy_simcard'] ?? 'Купить сим-карту',
            'application_id' => $application->id,
            'user_id' => auth()->user()->id
        ];
        

        $paymentParams['action'] = 'agent';
        PaymentAction::create($paymentParams);

        $paymentParams['fee'] = $application->plan->price_arrival;
        $paymentParams['action'] = 'provider';
        PaymentAction::create($paymentParams);

        Notification::create([
            'application_id' => $application->id,
            'agent_id' => $application->agent_id,
            'message' =>  Config::get('a_status')['buy_simcard'] ?? 'Купить сим-карту',
            'user_id' => auth()->user()->id
        ]);
    }

    public function updating(Application $application)
    {
    }

    /**
     * Handle the Application "updated" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function updated(Application $application)
    {
        if ($application->isDirty('status')) {
            // notification
            $notificationParams = [
                'application_id' => $application->id,
                'agent_id' => $application->agent_id,
                'user_id' => auth()->user()->id,
            ];
            if ($application->status == 'accepted') {
                $notificationParams['message'] = Config::get('a_status')['order_accepted'] ?? 'Заказ принят!';
                                if(auth()->user()->isUser()){
                $agent = Agent::where('id', auth()->user()->User_id())->first();
                $agentParams['balance'] = ($agent->balance - $application->plan->price_user);
                $agent->update($agentParams);
                }
            } elseif ($application->status == 'cancel') {
                $notificationParams['message'] = request()->comment;
            } elseif ($application->status == 'cancelled') {
                $notificationParams['message'] = Config::get('a_status')['cancelled'] ?? 'Заказ отменен!';
                // agent
                $agent = Agent::where('id', $application->agent_id)->first();
                $agentParams['balance'] = ($agent->balance + $application->plan->price_sell);
                $agent->update($agentParams);

                // provider
                $provider = Provider::where('id',$application->plan->provider_id)->first();
                $provider->update([
                    'balance' => $provider->balance + $application->plan->price_arrival,
                ]);

                $paymentParams = [
                    'type' => 'entry',
                    'action' => 'agent',
                    'agent_id' => $agent->id,
                    'simcard_id' => $application->simcard_id,
                    'fee' =>  $application->plan->price_sell,
                    'message' => request()->comment ?? Config::get('a_status')['cancelled'] ?? 'Заказ отменен!',
                    'application_id' => $application->id,
                    'user_id' => auth()->user()->id
                ];

                PaymentAction::create($paymentParams);

                $paymentParams['action'] = 'provider';
                $paymentParams['fee'] = $application->plan->price_arrival;
                PaymentAction::create($paymentParams);
                
            }
            Notification::create($notificationParams);
        }
    }

    /**
     * Handle the Application "deleted" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function deleted(Application $application)
    {
        
    }

    /**
     * Handle the Application "restored" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function restored(Application $application)
    {
    }

    /**
     * Handle the Application "force deleted" event.
     *
     * @param  \App\Models\Application  $application
     * @return void
     */
    public function forceDeleted(Application $application)
    {
        //
    }
}

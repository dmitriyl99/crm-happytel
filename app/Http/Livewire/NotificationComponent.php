<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notification;

class NotificationComponent extends Component
{
    public $notifications  = [];
    public function mount()
    {
       
        if(auth()->user()->role == 'admin')
        {
            $this->notifications  = Notification::where('is_read',1)->get();
        }
    }

    public function markAsRead()
    {
        if(auth()->user()->role == 'admin')
        {
            $this->notifications  = Notification::where('is_read',1)->get();
            foreach($this->notifications as $item)
            {
                $item->update([
                    'is_read' => 2
                ]);
            }
        }
    }
    public function render()
    {
        $this->emit('test');
        return view('livewire.notification-component');
    }
}

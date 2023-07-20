<?php

namespace App\Http\Livewire\Form;

use Livewire\Component;

class SimcardComponent extends Component
{
    public $simcards = [];
    public $simcard;
    public $esim = false;
    public $manual = false;

    public function mount($simcards)
    {
//         foreach($simcards as $item)
//         {
//             if(!$item  && in_array($item,$this->simcards)){
//                 continue;
//             }
//             $this->simcards[$item] = $item;
//         }
    }

    public function render()
    {
        return view('livewire.form.simcard-component');
    }

    public function addSimcard()
    {
        $this->simcards["{$this->simcard}"] = [
            'ssid' => $this->simcard,
            'esim' => $this->esim ?? null,
        ];
        $this->simcard = '';
        $this->esim = false;
    }

    public function updatedSimcard()
    {
        if(strlen($this->simcard) > 10 && $this->manual == false){
            $this->simcards["{$this->simcard}"] = [
                'ssid' => $this->simcard,
                'esim' => $this->esim ?? null
            ];
            $this->simcard = '';
            $this->esim = false;
        }
    }

    public function removeSimcard($id)
    {
        unset($this->simcards["{$id}"]);
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Application;
use Livewire\WithPagination;

class ApplicationList extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $searchedKey;
    public $status;
    public $filter = [
        'user_id' => '',
        'agent_id' => '',
        'status' => '',
    ];
    public $agent_id;

    public function updatedKey()
    {
    }

    public function mount($status)
    {
        $this->status = $status;

        if (auth()->user()->isAdmin()) {
            if (request()->agent_id) {
                $this->filter['agent_id'] = request()->agent_id;
            }
            if (request()->user_id) {
                $this->filter['user_id'] = request()->user_id;
            }
        } elseif (!auth()->user()->isAdmin()) {
            $this->filter['agent_id'] = auth()->user()->agent->id;
        }

        if (request()->filter_status) {
            $this->filter['status'] = request()->filter_status;
        }
    }

    public function render()
    {
        $applications = Application::where(function ($query) {
            if ($this->status != 'all' && !request()->filter_status) {
                $query->where('status', $this->status);
            }
            if (auth()->user()->isUser()) {
                $query->where(function ($query) {
                    $query->whereHas('plan', function ($query) {
                        $query->where('provider_id', 1);
                    });
                });
                if (request()->date_start) {
                        $query->where('date_start', '=', date('Y-m-d 00:00:00', strtotime(request()->date_start)));
                }
                $query->where('created_at', '>=', date('Y-m-d', strtotime('2022-11-8 00:00:00')));
            } else {
                if ($this->filter['status']) {
                    $query->where('status', $this->filter['status']);
                }
                if ($this->filter['agent_id']) {
                    $query->where('agent_id', $this->filter['agent_id']);
                }
                if ($this->filter['user_id']) {
                    $query->where('user_id', $this->filter['user_id']);
                }
            }
            if ($this->searchedKey) {
                $query->where(function ($query) {
                    $query->whereHas('simcard', function ($query) {
                        $query->where('ssid', 'like', '%' . $this->searchedKey . '%');
                    });
                })->orWhere(function ($query) {
                    $query->whereHas('customer', function ($query) {
                        $query->where('full_name', 'like', '%' . $this->searchedKey . '%');
                        $query->orWhere('phone', 'like', '%' . $this->searchedKey . '%');
                    });
                });
            }
        })->with(['customer', 'region', 'plan', 'simcard'])->orderBy('created_at', 'DESC')->paginate(20);
        return view('livewire.application-list', ['applications' => $applications]);
    }
}

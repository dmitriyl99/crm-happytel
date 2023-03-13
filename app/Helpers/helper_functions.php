<?php

use App\Models\Setting;

function getPaymentTypes()
{
    return Setting::where('type','payment_types')->get();
}

function customDate($date)
{
    if($date){
        return date('d-m-Y',strtotime($date));
    }
    return false;
    
}

function customPaymentType($type)
{

    $type = strtoupper($type);
    switch ($type) {
        case 'CASH':
            $text = "наличка";
            $color = "primary";
            break;
        case 'HUMO':
            $text = "HUMO";
            $color = "success";
            break;
        case 'UZCARD':
            $text = "UZCARD";
            $color = "success";
            break;
        case 'VISA':
            $text = "VISA";
            $color = "success";
            break;
        case 'CLICK':
            $text = "CLICK";
            $color = "success";
            break;
        case 'PAYME':
            $text = "PAYME";
            $color = "success";
            break;
        
        default:
            $text = "OTHER";
            $color = 'secondary';
            break;
    }

    echo "<span class='btn btn-{$color} btn-sm'>{$text}</span>";
}

function customStatusColor($status)
{
    $status = strtoupper($status);
    switch ($status) {
        case 'NEW':
            $color = "warning";
            break;
        case 'ACCEPTED':
            $color = "success";
            break;
        case 'ADDITIONAL':
            $color = "primary";
            break;
        
        default:
            $color = 'secondary';
            break;
    }

    echo "<span class='btn btn-{$color} btn-sm'>{$status}</span>";
}

function getOrdersCount()
{
    $data['new'] = \App\Models\Application::where(function($query){
        $query->where('status','new');
        if(auth()->user()->role == 'agent'){
            $query->where('agent_id',auth()->user()->agent_id);
        }
    })->count();

    $data['accepted'] = \App\Models\Application::where(function($query){
        $query->where('status','accepted');
        if(auth()->user()->role == 'agent'){
            $query->where('agent_id',auth()->user()->agent_id);
        }
    })->count();

    $data['expired'] = \App\Models\Application::where(function($query){
        $query->where('status','expired');
        if(auth()->user()->role == 'agent'){
            $query->where('agent_id',auth()->user()->agent_id);
        }
    })->count();

    $data['cancel'] = \App\Models\Application::where(function($query){
        $query->where('status','cancel');
        if(auth()->user()->role == 'agent'){
            $query->where('agent_id',auth()->user()->agent_id);
        }
    })->count();

    $data['all'] = \App\Models\Application::where(function($query){
        if(auth()->user()->role == 'agent'){
            $query->where('agent_id',auth()->user()->agent_id);
        }
    })->count();
    

    return $data;
}

function updateSettings($filename,$array)
{
    $data = var_export($array, 1);
    if(File::put(__dir__.'/../../config/'.$filename.'.php', "<?php\n return $data ;")) {
        echo "success";
    }
}

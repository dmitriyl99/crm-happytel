<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simcard extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function agent(){
        return $this->hasOne(\App\Models\Agent::class,'id','agent_id');
    } 

    public function regions()
    {
        return $this->belongsToMany(Region::class,'simcard_region','simcard_id','region_id');
    }
    
    public function region_groups()
    {
        return $this->belongsToMany(RegionGroup::class,'region_group_simcard','simcard_id','region_group_id');
    }
}

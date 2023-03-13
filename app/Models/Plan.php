<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function regions()
    {
        return $this->belongsToMany(Region::class,'plan_region','plan_id','region_id');
    }
    
    public function region_group()
    {
        return $this->hasOne(\App\Models\RegionGroup::class,'id','region_group_id');
    }

    public function region()
    {
        return $this->hasOne(\App\Models\Region::class,'id','region_id');
    }

    public function provider()
    {
        return $this->hasOne(\App\Models\Provider::class,'id','provider_id');
    }
}

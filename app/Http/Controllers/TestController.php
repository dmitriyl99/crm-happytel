<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\Region;
use App\Models\Simcard;
use Illuminate\Http\Request;
use Faker\Generator as Faker;

class TestController extends Controller
{

    public function index(Faker $faker)
    {
        // $start_date = $faker->dateTimeBetween("-1 year",'+2 months');
        // dd($start_date->format('Y-m-d H:i:s'));
        $simcards = Simcard::all();
        $customers = Customer::all();
        foreach($customers as $customer)
        {
            for($i = 0; $i < rand(1,20); $i++)
            {
                $weeks = rand(1,8);
                $start_date = $faker->dateTimeBetween("-1 year",'+2 months');
                $end_date = $faker->dateTimeBetween($start_date,"{$start_date->format('Y-m-d')} +{$weeks} weeks");

                $selectedSimcards = $simcards->random(rand(1,5));
                $simcard = $selectedSimcards->first();
                $simcardIds = $selectedSimcards->pluck('id')->toArray();
   
                $application = Application::create([
                    'region_id' => $simcard->region_id,
                    'plan_id' => $simcard->plan_id,
                    'agent_id' => rand(1,3),
                    'date_start' => $start_date->format('Y-m-d H:i:s'),
                    'date_finish' => $end_date->format('Y-m-d H:i:s'),
                    'customer_id' => $customer->id,
                    'status' => $faker->randomElement(['new','active','inactive']),
                    'payment_type' => $faker->randomElement(['cash','online']),
                ]);
                $application->update(['number' => 'N-'.sprintf("%'.05d\n", $application->id)]);
                $application->simcards()->attach($simcardIds);
            }
        }
        
    }


    public function generateCustomer(Faker $faker)
    {
        for($i = 0; $i < 1000; $i++)
        {
            $phone = str_replace('+','',$faker->e164PhoneNumber);
            $item = Customer::where('phone',$phone)->first();
            if($item){
                continue;
            }
            Customer::create([
                'full_name' => $faker->firstName.' '. $faker->lastName,
                'phone' => $phone,
                'agent_id' => $faker->randomElement([1,2,3]),
                'passport' => $faker->imageUrl($width = 640, $height = 480),
                'status' => 'active'
            ]);
        }
    }
    public function generateSimcard(Faker $faker)
    {
        $plans = Plan::all();
        for($i = 0; $i < 5000; $i++)
        {
            $ssid = $faker->numberBetween(999999999999999999999,100000000000000000000);
            $item = Simcard::where('ssid',$ssid)->first();
            if($item){
                continue;
            }
            $plan = $plans->random(1)->first();
            Simcard::create([
                'ssid' => $ssid,
                'region_id' => $plan->region_id,
                'plan_id' => $plan->id,
                'price' => $faker->randomElement([15000,20000,30000,35000,40000,45000,50000]),
            ]);
        }
    }

    public function generatePlan(Faker $faker)
    {
        $regions = Region::all();
        for($i = 0; $i < 20; $i++)
        {
            $str = $faker->text('20');
            $item = Plan::where('name',$str)->first();
            if($item){
                continue;
            }
            Plan::create([
                'name' => $str,
                'quantity_sms' => $faker->randomElement([0,50,100,200,300]),
                'expiry_day' => $faker->randomElement([7,10,14,20,30]),
                'region_id' => $regions->random(1)->first()->id,
                'quantity_minut' => $faker->randomElement([100,0,300,500,200]),
                'quantity_internet' => $faker->randomElement([1,2,3,4,5,10]),
                'price_arrival' => $faker->numberBetween(10000,30000),
                'price_sell' => $faker->numberBetween(30000,70000),
            ]);
        }
    }

    public function createRegion(Faker $faker)
    {
        for($i = 0; $i < 50; $i++)
        {
            $country = $faker->country;
            $region = Region::where('name',$country)->first();
            if($region){
                continue;
            }
            Region::create([
                'name' => $country
            ]);
        }
    }
}

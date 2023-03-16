<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimcardImportRequest;
use App\Http\Requests\SimcardReuquest;
use App\Models\Plan;
use App\Models\Region;
use App\Models\RegionGroup;
use App\Models\Simcard;
use Illuminate\Http\Request;
use App\Http\Requests\SimcardRequest;
use App\Models\Agent;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SimCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $regions = Region::where('status', 'active')->get();
        $agents = Agent::where('status', 'active')->get();
        $simcards = Simcard::where(function ($query) use ($request) {

            if ($request->agent_id) {
                $query->where('agent_id', '=', $request->agent_id);
            }
            if ($request->ssid) {
                $query->where('ssid', 'like', "%{$request->ssid}%");
            }

            if(auth()->user()->role == 'agent' && !$request->agent_id)
            {
                if (auth()->user()->agent->id ?? false) {
                    $query->where('agent_id', '=', auth()->user()->agent->id);
                }
            }

        })->with(['agent', 'regions'])->paginate();

        return view('admin.simcard.index', compact('simcards', 'regions', 'agents'));
    }

    public function edit($id)
    {
        abort_if(!auth()->user()->id, 403);

        $simcard = Simcard::findOrFail($id);
        $regions = Region::all();
        $agents = Agent::all();
        $region_groups = RegionGroup::all();

        return view('admin.simcard.edit', compact('simcard','regions','agents','region_groups'));
    }

    public function update($id)
    {
        request()->validate([
            'ssid' => ['required'],
//             'status' => ['required'],
            'region_groups.*' => ['required'],
            'agent_id' => ['required'],

        ]);
        $simcard = Simcard::findOrFail($id);
        $simcard->update([
            'ssid' => request()->ssid,
            'agent_id' => request()->agent_id,
        ]);

        $simcard->region_groups()->sync(request()->region_groups);
        return back()->with(['success' => 'Успешно обновлено']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $simcard = Simcard::findOrFail($id);
        $simcard->delete();
        return redirect()->route('admin.simcard.index')->with(['success' => 'Успешно удалено!']);
    }


    public function changeAgentStore(Request $request)
    {
        $request->validate([
            'simcards' => 'required',
            'agent_id' => 'required',
        ]);

        foreach ($request->simcards as $ssid) {
            if ($ssid) {
                $simcard = Simcard::where('ssid',$ssid)->first();
                if($simcard)
                {
                    $simcard->update([
                        'agent_id' => $request->agent_id,
                    ]);
                }

            }
        }
        return back()->with(['success' => 'Успешно обновлено']);
    }

    public function changeAgent(Request $request)
    {
        $agents = Agent::all();
        return view('admin.simcard.changeagent', compact('agents'));
    }

    public function MassCreate()
    {
//         $regions = Region::all();
        $agents = Agent::all();
        $region_groups = RegionGroup::all();
        return view('admin.simcard.masscreate', compact('region_groups','agents'));
    }

    public function MassStore(SimcardRequest $request)
    {
//         foreach ($request->simcards as $item) {
//             if (!$item) {
//                 continue;
//             }
//             $simcard = Simcard::where('ssid', $item)->first();
//             if (!$simcard) {
//                 $simcard = Simcard::create([
//                     'ssid' => $item,
//                     'price' => $request->price,
//                     'status' => 'inactive',
//                 ]);

//                 $simcard->regions()->attach($request->regions);

//             } else {
//                 $simcard->regions()->sync($request->regions);
//             }
//         }
        foreach ($request->simcards as $item) {
            if (!$item) {
                continue;
            }
            $simcard = Simcard::where('ssid', $item)->first();
            if (!$simcard) {
                $simcard = Simcard::create([
                    'ssid' => $item,
                    'price' => $request->price,
                    'status' => 'inactive',
                    'agent_id' => $request->agent_id,
                ]);

                $simcard->region_groups()->attach($request->region_groups);

            } else {
                $simcard->region_groups()->sync($request->region_groups);
            }
        }

        return redirect()->route('admin.simcard.index')->with(['succes' => 'Successfully created!']);
    }

    public function massImport(SimcardImportRequest $request)
    {
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->path());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = array_slice($sheet->toArray(), 1);
        foreach ($rows as $key => $row) {
            $agent_name = $row[0];
            $region_groups_names = explode(',', $row[1]);
            foreach ($region_groups_names as $key => $region_groups_name) {
                $region_groups_names[$key] = trim($region_groups_name);
            }
            $simcards = explode(' ', $row[2]);
            /** @var Agent $agent */
            $agent = Agent::query()->where('title', $agent_name)->first();
            if ($agent === null) {
                return redirect()->route('admin.simcard.index')->with(['error' => "Агент $agent_name не найден"]);
            }
            $region_groups = RegionGroup::query()->whereIn('name', $region_groups_names)->pluck('id');
            if (count($region_groups_names) !== $region_groups->count()) {
                $row_number = $key + 1;
                return redirect()->route('admin.simcard.index')->with(['error' => "Неправильная регион группа в строке $row_number"]);
            }
            foreach ($simcards as $simcard_ssid) {
                /** @var Simcard $simcard */
                $simcard = Simcard::query()->where('ssid', $simcard_ssid)->first();
                if ($simcard === null) {
                    /** @var Simcard $simcard */
                    $simcard = Simcard::query()->create([
                        'ssid' => $simcard_ssid,
                        'price' => null,
                        'status' => 'inactive',
                        'agent_id' => $agent->id,
                    ]);

                    $simcard->region_groups()->attach($region_groups->toArray());

                } else {
                    $simcard->region_groups()->sync($region_groups->toArray());
                }
            }
        }
        return redirect()->route('admin.simcard.index')->with(['succes' => 'Successfully created!']);
    }

}

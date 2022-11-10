<?php

namespace App\Http\Controllers\classroom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Batch;
use App\Models\ClassUnit;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Batch $batch)
    {
        $units = $batch->units;
        return view('admin.batches.units.index',compact('batch','units'));
    }

    public function store(Batch $batch, Request $request)
    {
        // dd($request->all());
        $request->validate(['unit'=>'required|string|min:2']);
        $batch->units()->create([
            'name'=> ucwords($request->unit),
            'slug' => Str::slug($request->unit),
        ]);

        return redirect('/admin/batches/'.$batch->id.'/units');
    }

    public function update(Batch $batch, Request $request)
    {
        // dd($request->all(),$batch);
        $request->validate([
            'unit_id' => 'numeric|required|min:1',
            'unit_name' => 'string|required|min:1',
        ]);

        $unit = ClassUnit::find($request->unit_id);
        if(!$unit)
        {
            return back()->withInput()->withErrors(['unit_id'=>'Unit Not Defined']);
        }
        $unit->update([
            'name'=> ucwords($request->unit_name),
            'slug' => Str::slug($request->unit_name),
        ]);

        return redirect('/admin/batches/'.$batch->id.'/units');
    }

    public function destroy(Batch $batch, ClassUnit $unit)
    {
        // dd($batch,$unit);
        $unit->delete();
        return redirect('/admin/batches/'.$batch->id.'/units');
    }
}

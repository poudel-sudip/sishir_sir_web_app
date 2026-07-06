<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Categories as Dictionary;

class DictionaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $dictionary = collect([]);
        
        if(isset($request->json_type) && $request->json_type == 1)
        {
            $dictionary = Dictionary::where('type','=','health_dictionary')
            ->select(['id','name as title','description as content','created_at']);

            return DataTables::of($dictionary)
            ->filter(function ($query) {
                $keyword = request('search.value');

                if ($keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', $keyword.'%');
                        // $q->orWhere('description', 'LIKE', $keyword.'%');
                    });
                }
            }, false) // Disable the default global search
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                return "
                    <div class='dropdown'>
                        <button class='btn btn-info dropdown-toggle' type='button' id='dropdownMenuOutlineButton".$row->id."' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> Actions </button>
                        <div class='dropdown-menu' aria-labelledby='dropdownMenuOutlineButton".$row->id."'>
                            <a href='/admin/health-dictionary/".$row->id."' class='text-primary dropdown-item'>Show</a>
                            <a href='/admin/health-dictionary/".$row->id."/edit' class='text-danger dropdown-item'>Edit</a>
                            
                            <form id='delete-form-".$row->id."' action='/admin/health-dictionary/".$row->id."' method='POST' style='display: inline;'>
                                ".csrf_field()."
                                ".method_field('DELETE')."
                                <a href='javascript:void(0);' onclick='deleteData(".$row->id.");' class='text-warning dropdown-item'>Delete</a>
                            </form>
                        </div>
                    </div>
                ";
                
            })
            ->rawColumns(['action','content'])
            ->make(true);

        }

        
        return view('admin.dictionary.index',[
            'dictionary'=>$dictionary,
        ]);
        
    }

    public function create()
    {
        return view('admin.dictionary.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Dictionary::create([
            'name' => $request->title,
            'description' => $request->description,
            'type' => 'health_dictionary',
            'status' => 'Active',
        ]);

        return redirect('/admin/health-dictionary')->with('success', 'Content created successfully.');
    }

    public function edit(Dictionary $dictionary)
    {
        return view('admin.dictionary.edit', compact('dictionary'));
    }

    public function update(Request $request, Dictionary $dictionary)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $dictionary->update([
            'name' => $request->title,
            'description' => $request->description,
        ]);

        return redirect('/admin/health-dictionary')->with('success', 'Content updated successfully.');
    }

    public function destroy(Dictionary $dictionary)
    {
        $dictionary->delete();

        return redirect('/admin/health-dictionary')->with('success', 'Content deleted successfully.');
    }

    public function show(Dictionary $dictionary)
    {
        return view('admin.dictionary.show', compact('dictionary'));
    }
}

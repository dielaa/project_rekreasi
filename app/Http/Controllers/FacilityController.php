<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;
use App\Exports\FacilityExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('facility.index');
    }

    public function getFacilities(Request $request)
    {
            $facilities = Facility::query();
            return DataTables::of($facilities)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('dashboard.facility.edit',['id'=>$row->id]).'" class="btn btn-warning btn-sm">Edit</a> ';
                    $actionBtn .= '<form action="'.route('dashboard.facility.delete', ['id' => $row->id]).'" method="POST" style="display:inline;">';
                    $actionBtn .= csrf_field() . method_field('DELETE');
                    $actionBtn .= '<button type="submit" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-sm">Delete</button></form>';
                    return $actionBtn;
                })
                // ->filter(function ($query) use ($request) {
                //     if ($request->get('search')['value']) {
                //         $searchValue = $request->get('search')['value'];
                //         $query->where(function($query) use ($searchValue) {
                //             $query->where('name', 'like', "%{$searchValue}%")
                //                 ->orWhere('location', 'like', "%{$searchValue}%")
                //                 ->orWhere('description', 'like', "%{$searchValue}%")
                //                 ->orWhere('capacity', 'like', "%{$searchValue}%")
                //                 ->orWhere('operational_hours', 'like', "%{$searchValue}%")
                //                 ->orWhere('status', 'like', "%{$searchValue}%");
                //         });
                //     }
                // })
                ->rawColumns(['action'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('facility.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'description' => 'required',
            'capacity' => 'required',
            'operational_hours' => 'required',
            'status' => 'required'
        ], [
            'name.required' => 'Name must be filled',
            'location.required' => 'Location must be filled',
            'description.required' => 'Description must be filled',
            'capacity.required' => 'Capacity must be filled',
            'operational_hours.required' => 'Operational must be filled',
            'status.required' => 'Status must be filled'
        ]);
        $createData = Facility::create([
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'operational_hours' => $request->operational_hours,
            'status'=> $request->status
        ]);
        if ($createData) {
            return redirect()->route('dashboard.facility.index')->with('success', 'Successfully add Facility!');
        } else {
            return redirect()->back()->with('error', 'Failed! Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $facilities = Facility::find($id);
        return view('facility.edit', compact('facilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $id)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'description' => 'required',
            'capacity' => 'required',
            'operational_hours' => 'required',
            'status' => 'required'
        ], [
            'name.required' => 'Name must be filled',
            'location.required' => 'Location must be filled',
            'description.required' => 'Description must be filled',
            'capacity.required' => 'Capacity must be filled',
            'operational_hours.required' => 'Operational must be filled',
            'status.required' => 'Status must be filled'
        ]);
        $updateData = $id->update([
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'operational_hours' => $request->operational_hours,
            'status'=> $request->status
        ]);
        if ($updateData) {
            return redirect()->route('dashboard.facility.index')->with('success', 'Successfully edit Facility!');
        } else {
            return redirect()->back()->with('error', 'Failed! Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $id)
    {
        $deleteData = $id->delete();
        if($deleteData) {
            return redirect()->route('dashboard.facility.index')->with('success', 'Successfully delete facility!');
        } else {
            return redirect()->back()->with('failed', 'Failed! Please try again.');
        }
    }

    public function listFacility()
    {
        $facilities = Facility::all();
        return view('listFacility', compact('facilities'));
    }

    public function export()
    {
        $file_name = 'data-facility.xlsx';
        return Excel::download(new FacilityExport, $file_name);
    }

    public function trash()
    {
        return view('facility.trash');
    }

    public function getTrashFacilities(Request $request)
    {
        $facilities = Facility::onlyTrashed()->select('*');
        return DataTables::of($facilities)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<form action="'.route('dashboard.facility.restore', ['id' => $row->id]).'" method="POST" style="display:inline;">';
                $actionBtn .= csrf_field() . method_field('PATCH');
                $actionBtn .= '<button type="submit" class="btn btn-success btn-sm me-2">restore</button></form>';
                $actionBtn .= '<form action="'.route('dashboard.facility.delete_permanent', ['id' => $row->id]).'" method="POST" style="display:inline;">';
                $actionBtn .= csrf_field() . method_field('DELETE');
                $actionBtn .= '<button type="submit" onclick="return confirm(\'Are you sure to delete permanently?\')" class="btn btn-danger btn-sm">Delete Permanent</button></form>';
                return $actionBtn;
            })
            // ->filter(function ($query) use ($request) {
            //         if ($request->get('search')['value']) {
            //             $searchValue = $request->get('search')['value'];
            //             $query->where(function($query) use ($searchValue) {
            //                 $query->where('name', 'like', "%{$searchValue}%")
            //                     ->orWhere('location', 'like', "%{$searchValue}%")
            //                     ->orWhere('description', 'like', "%{$searchValue}%")
            //                     ->orWhere('capacity', 'like', "%{$searchValue}%")
            //                     ->orWhere('operational_hours', 'like', "%{$searchValue}%")
            //                     ->orWhere('status', 'like', "%{$searchValue}%");
            //             });
            //         }
            //     })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function restore($id)
    {
        $facilities = Facility::onlyTrashed()->find($id);
        $facilities->restore();

        return redirect()->route('dashboard.facility.index')->with('success', 'Successfully restore data!');
    }

    public function deletePermanent($id)
    {
        $facilities = Facility::onlyTrashed()->find($id);
        $facilities->forceDelete();

        return redirect()->route('dashboard.facility.index')->with('success', 'Successfully delete permanent data!');
    }

}

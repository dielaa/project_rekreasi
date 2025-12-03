<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;
use App\Exports\PromoExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('promo.index');
    }

    public function getPromo(Request $request)
    {
        $promos = Promo::query();
        return DataTables::of($promos)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<a href="' . route('dashboard.promo.edit', ['id' => $row->id]) . '" class="btn btn-warning btn-sm">Edit</a> ';
                $actionBtn .= '<form action="' . route('dashboard.promo.delete', ['id' => $row->id]) . '" method="POST" style="display:inline;">';
                $actionBtn .= csrf_field() . method_field('DELETE');
                $actionBtn .= '<button type="submit" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-sm">Delete</button></form>';
                return $actionBtn;
            })
            // ->filter(function ($query) use ($request) {
            //     if ($request->get('search')['value']) {
            //         $searchValue = $request->get('search')['value'];
            //         $query->where(function ($query) use ($searchValue) {
            //             $query->where('name', 'like', "%{$searchValue}%")
            //                 ->orWhere('description', 'like', "%{$searchValue}%")
            //                 ->orWhere('percent', 'like', "%{$searchValue}%")
            //                 ->orWhere('start_date', 'like', "%{$searchValue}%")
            //                 ->orWhere('end_date', 'like', "%{$searchValue}%");
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
        return view('promo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'percent' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ], [
            'name.required' => 'Name must be filled',
            'description' => 'Description must be filled',
            'percent.required' => 'Percent must be filled',
            'start_date.required' => 'Start date must be filled in',
            'start_date.date' => 'Start date must be filled with date',
            'end_date.required' => 'End date must be filled in',
            'end_date.date' => 'End date must be filled with date',
        ]);
        $createData = Promo::create([
            'name' => $request->name,
            'description' => $request->description,
            'percent' => $request->percent,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        if ($createData) {
            return redirect()->route('dashboard.promo.index')->with('success', 'Successfully add promo!');
        } else {
            return redirect()->back()->with('error', 'Failed! Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Promo $promo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $promos = Promo::find($id);
        return view('promo.edit', compact('promos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promo $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'percent' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ], [
            'name.required' => 'Name must be filled',
            'description' => 'Description must be filled',
            'percent.required' => 'Percent must be filled',
            'start_date.required' => 'Start date must be filled in',
            'start_date.date' => 'Start date must be filled with date',
            'end_date.required' => 'End date must be filled in',
            'end_date.date' => 'End date must be filled with date',
        ]);
        $updateData = $id->update([
            'name' => $request->name,
            'description' => $request->description,
            'percent' => $request->percent,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        if ($updateData) {
            return redirect()->route('dashboard.promo.index')->with('success', 'Successfully add promo!');
        } else {
            return redirect()->back()->with('error', 'Failed! Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promo $id)
    {
        $deleteData = $id->delete();
        if ($deleteData) {
            return redirect()->route('dashboard.promo.index')->with('success', 'Successfully delete Promo!');
        } else {
            return redirect()->back()->with('failed', 'Failed! Please try again.');
        }
    }

    public function export()
    {
        $file_name = 'data-promo.xlsx';
        return Excel::download(new PromoExport, $file_name);
    }

    public function listPromo(Request $request)
    {
        $promo = Promo::orderBy('start_date', 'desc')->get();
        return view('listPromo', compact('promo'));
    }

    public function trash()
    {
        return view('promo.trash');
    }

    public function getTrashPromo(Request $request)
    {
        $promos = Promo::onlyTrashed()->select('*');
        return DataTables::of($promos)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<form action="' . route('dashboard.promo.restore', ['id' => $row->id]) . '" method="POST" style="display:inline;">';
                $actionBtn .= csrf_field() . method_field('PATCH');
                $actionBtn .= '<button type="submit" class="btn btn-success btn-sm me-2">restore</button></form>';
                $actionBtn .= '<form action="' . route('dashboard.promo.delete_permanent', ['id' => $row->id]) . '" method="POST" style="display:inline;">';
                $actionBtn .= csrf_field() . method_field('DELETE');
                $actionBtn .= '<button type="submit" onclick="return confirm(\'Are you sure to delete permanently?\')" class="btn btn-danger btn-sm">Delete Permanent</button></form>';
                return $actionBtn;
            })
            // ->filter(function ($query) use ($request) {
            //     if ($request->get('search')['value']) {
            //         $searchValue = $request->get('search')['value'];
            //         $query->where(function($query) use ($searchValue) {
            //             $query->where('name', 'like', "%{$searchValue}%")
            //                 ->orWhere('description', 'like', "%{$searchValue}%")
            //                 ->orWhere('percent', 'like', "%{$searchValue}%")
            //                 ->orWhere('start_date', 'like', "%{$searchValue}%")
            //                 ->orWhere('end_date', 'like', "%{$searchValue}%");
            //         });
            //     }
            // })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function restore($id)
    {
        $promos = Promo::onlyTrashed()->find($id);
        $promos->restore();

        return redirect()->route('dashboard.promo.index')->with('success', 'Successfully restore data!');
    }

    public function deletePermanent($id)
    {
        $promos = Promo::onlyTrashed()->find($id);
        $promos->forceDelete();

        return redirect()->route('dashboard.promo.index')->with('success', 'Successfully delete permanent data!');
    }
}

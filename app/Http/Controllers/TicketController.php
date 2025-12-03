<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\Promo;
use App\Exports\TicketExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ticket.index');
    }

    public function getTicket(Request $request)
    {
        $tickets = Ticket::with('promo')->select('tickets.*');
        return DataTables::of($tickets)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($row) {
                if ($row->thumbnail) {
                    $url = asset('storage/' . $row->thumbnail);
                    return '<img src="' . $url . '" alt="Thumbnail" style="width: 200px;">';
                }
                return '-';
            })
            ->addColumn('promo_name', function ($row) {
                return $row->promo ? $row->promo->name . ' (' . $row->promo->percent . '%)' : '-';
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<a href="' . route('dashboard.ticket.edit', ['id' => $row->id]) . '" class="btn btn-warning btn-sm">Edit</a> ';
                $actionBtn .= '<form action="' . route('dashboard.ticket.delete', ['id' => $row->id]) . '" method="POST" style="display:inline;">';
                $actionBtn .= csrf_field() . method_field('DELETE');
                $actionBtn .= '<button type="submit" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-sm">Delete</button></form>';
                return $actionBtn;
            })
            ->filter(function ($query) use ($request) {
                if ($request->get('search')['value']) {
                    $searchValue = $request->get('search')['value'];
                    $query->where(function ($query) use ($searchValue) {
                        $query->where('name', 'like', "%{$searchValue}%")
                            ->orWhere('description', 'like', "%{$searchValue}%")
                            ->orWhere('price', 'like', "%{$searchValue}%")
                            ->orWhere('start_date', 'like', "%{$searchValue}%")
                            ->orWhere('end_date', 'like', "%{$searchValue}%")
                            ->orWhereHas('promo', function ($q) use ($searchValue) {
                                $q->where('name', 'like', "%{$searchValue}%"); // cari di promo.name
                            });
                        ;
                    });
                }
            })
            ->rawColumns(['action', 'thumbnail'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $promos = Promo::all();
        return view('ticket.create', compact('promos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'thumbnail' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'price' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ], [
            'name.required' => 'Name must be filled',
            'description' => 'Description must be filled',
            'start_date.required' => 'Start date must be filled in',
            'start_date.date' => 'Start date must be filled with date',
            'end_date.required' => 'End date must be filled in',
            'end_date.date' => 'End date must be filled with date',
        ]);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('ticket/thumbnail', $filename, 'public');
        }

        $createData = Ticket::create([
            'name' => $request->name,
            'price' => $request->price,
            'thumbnail' => $path,
            'description' => $request->description,
            'promo_id' => $request->promo_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        if ($createData) {
            return redirect()->route('dashboard.ticket.index')->with('success', 'Successfully add ticket!');
        } else {
            return redirect()->back()->with('error', 'Failed! Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $id)
    {
        $promos = Promo::all();
        $data = $id;
        return view('ticket.edit', compact('data', 'promos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ], [
            'name.required' => 'Name must be filled',
            'description' => 'Description must be filled',
            'start_date.required' => 'Start date must be filled in',
            'start_date.date' => 'Start date must be filled with date',
            'end_date.required' => 'End date must be filled in',
            'end_date.date' => 'End date must be filled with date',
        ]);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('ticket/thumbnail', $filename, 'public');
        }

        $updateData = $id->update([
            'name' => $request->name,
            'thumbnail' => isset($path) ? $path : $id->thumbnail,
            'price' => $request->price,
            'description' => $request->description,
            'promo_id' => $request->promo_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        if ($updateData) {
            return redirect()->route('dashboard.ticket.index')->with('success', 'Successfully update ticket!');
        } else {
            return redirect()->back()->with('error', 'Failed! Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $id)
    {
        $deleteData = $id->delete();
        if ($deleteData) {
            return redirect()->route('dashboard.ticket.index')->with('success', 'Successfully delete ticket!');
        } else {
            return redirect()->back()->with('failed', 'Failed! Please try again.');
        }
    }

    public function export()
    {
        $file_name = 'data-ticket.xlsx';
        return Excel::download(new TicketExport, $file_name);
    }

    public function listTicket(Request $request)
    {
        $date = $request->input('date');
        if ($date) {
            session()->put('visit_date', $date);
        }

        if ($date) {
            $ticket = Ticket::query()->whereDate('start_date', '<=', $date)
                ->whereDate('end_date', '>=', $date)->get();
        } else {
            $ticket = [];
        }
        return view('listTicket', compact('ticket'));
    }

    public function trash()
    {
        $tickets = Ticket::onlyTrashed()->get();
        return view('ticket.trash', compact('tickets'));
    }

    public function getTrashTicket(Request $request)
    {
        $tickets = Ticket::with('promo')->onlyTrashed()->select('tickets.*');
        return DataTables::of($tickets)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($row) {
                if ($row->thumbnail) {
                    $url = asset('storage/' . $row->thumbnail);
                    return '<img src="' . $url . '" alt="Thumbnail" style="width: 200px;">';
                }
                return '-';
            })
            ->addColumn('promo_name', function ($row) {
                return $row->promo ? $row->promo->name . ' (' . $row->promo->percent . '%)' : '-';
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<form action="' . route('dashboard.ticket.restore', ['id' => $row->id]) . '" method="POST" style="display:inline;">';
                $actionBtn .= csrf_field() . method_field('PATCH');
                $actionBtn .= '<button type="submit" class="btn btn-success btn-sm me-2">restore</button></form>';
                $actionBtn .= '<form action="' . route('dashboard.ticket.delete_permanent', ['id' => $row->id]) . '" method="POST" style="display:inline;">';
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
            //                 ->orWhere('price', 'like', "%{$searchValue}%")
            //                 ->orWhere('start_date', 'like', "%{$searchValue}%")
            //                 ->orWhere('end_date', 'like', "%{$searchValue}%")
            //                 ->orWhereHas('promo', function ($q) use ($searchValue) {
            //                     $q->where('name', 'like', "%{$searchValue}%"); // cari di promo.name
            //                 });;
            //         });
            //     }
            // })
            ->rawColumns(['action', 'thumbnail'])
            ->make(true);
    }

    public function restore($id)
    {
        $tickets = Ticket::onlyTrashed()->find($id);
        $tickets->restore();

        return redirect()->route('dashboard.ticket.index')->with('success', 'Successfully restore data!');
    }

    public function deletePermanent($id)
    {
        $tickets = Ticket::onlyTrashed()->find($id);
        $tickets->forceDelete();

        return redirect()->route('dashboard.ticket.index')->with('success', 'Successfully delete permanent data!');
    }

    public function addToCart(Request $request)
    {
        $ticket = Ticket::find($request->ticket_id);
        $cart = session()->get('cart', []);
        if (isset($cart[$ticket->id])) {
            $cart[$ticket->id]['qty'] += 1;
        } else {
            $cart[$ticket->id] = [
                'name' => $ticket->name,
                'price' => $ticket->price,
                'qty' => 1
            ];
        }
        session()->put('cart', $cart);
        return back()->with('success', 'Ticket added to cart!');
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart');
        if ($cart && isset($cart[$request->id])) {
            $cart[$request->id]['qty'] = $request->qty;
            session()->put('cart', $cart);
        }
        return back();
    }

    public function removeCart(Request $request)
    {
        $cart = session()->get('cart');
        if (isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
        }
        return back();
    }

    public function reservation(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login dulu sebelum melanjutkan.');
        }
        $cart = session()->get('cart', []);
        $visitDate = session('visit_date');
        $promos = Promo::whereDate('start_date', '<=', $visitDate)
            ->whereDate('end_date', '>=', $visitDate)
            ->get();
        $promoId = $request->promo_id;
        $selectedPromo = Promo::find($promoId);
        $summary = [];
        foreach ($cart as $id => $item) {
            $ticket = Ticket::find($id);
            if (!$ticket)
                continue;
            $original = $ticket->price;
            if ($selectedPromo) {
                $discount = $original * ($selectedPromo->percent / 100);
                $final = $original - $discount;
            } else {
                $discount = 0;
                $final = $original;
            }

            $summary[] = [
                'name' => $item['name'],
                'qty' => $item['qty'],
                'original_price' => $original,
                'discount' => $discount,
                'final_price' => $final,
                'subtotal' => $final * $item['qty'],
                'promo_name' => $selectedPromo->name ?? null,
                'promo_percent' => $selectedPromo->percent ?? null,
            ];
        }

        $total = array_sum(array_column($summary, 'subtotal'));
        $totalTickets = array_sum(array_column($summary, 'qty'));
        $payments = Payment::all();


        return view('reservation', compact(
            'summary',
            'total',
            'visitDate',
            'promos',
            'payments',
            'totalTickets',
            'selectedPromo'
        ));
    }

    public function chartData()
    {
        $month = now()->format('m');

        $data = \DB::table('detail_transactions')
            ->whereMonth('date', $month)
            ->selectRaw('SUM(qty) as total')
            ->first();

        $label = now()->format('F');
        $value = $data->total ?? 0;

        return response()->json([
            'labels' => [$label],
            'data' => [$value]
        ]);
    }


    public function chartStatus()
    {
        $active = Ticket::where('end_date', '>=', now())->count();
        $expired = Ticket::where('end_date', '<', now())->count();

        return response()->json([
            'labels' => ['Active', 'Expired'],
            'data' => [$active, $expired]
        ]);
    }


}
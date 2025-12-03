<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\DetailTransaction;
use App\Models\Promo;
use App\Models\Ticket;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Exports\PaymentExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('payment.index');
    }

    public function getPayments(Request $request)
    {
        $payments = Payment::query();
        return DataTables::of($payments)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<a href="' . route('dashboard.payment.edit', ['id' => $row->id]) . '" class="btn btn-warning btn-sm">Edit</a> ';
                $actionBtn .= '<form action="' . route('dashboard.payment.delete', ['id' => $row->id]) . '" method="POST" style="display:inline;">';
                $actionBtn .= csrf_field() . method_field('DELETE');
                $actionBtn .= '<button type="submit" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-sm">Delete</button></form>';
                return $actionBtn;
            })
            ->filter(function ($query) use ($request) {
                if ($request->get('search')['value']) {
                    $searchValue = $request->get('search')['value'];
                    $query->where(function ($query) use ($searchValue) {
                        $query->where('type_payment', 'like', "%{$searchValue}%");
                    });
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_payment' => 'required'
        ], [
            'type_payment.required' => 'Type must be filled'
        ]);

        $createData = Payment::create([
            'type_payment' => $request->type_payment,
        ]);
        if ($createData) {
            return redirect()->route('dashboard.payment.index')->with('success', 'Successfully add type payment!');
        } else {
            return redirect()->back()->with('error', 'Failed! Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $payments = Payment::find($id);
        return view('payment.edit', compact('payments'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $id)
    {
        $request->validate([
            'type_payment' => 'required'
        ], [
            'type_payment.required' => 'Type must be filled'
        ]);

        $updateData = $id->update([
            'type_payment' => $request->type_payment,
        ]);
        if ($updateData) {
            return redirect()->route('dashboard.payment.index')->with('success', 'Successfully add type payment!');
        } else {
            return redirect()->back()->with('error', 'Failed! Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $id)
    {
        $deleteData = $id->delete();
        if ($deleteData) {
            return redirect()->route('dashboard.payment.index')->with('success', 'Successfully delete payment!');
        } else {
            return redirect()->back()->with('failed', 'Failed! Please try again.');
        }
    }

    public function export()
    {
        $file_name = 'data-payment.xlsx';
        return Excel::download(new PaymentExport(), $file_name);
    }

    public function trash()
    {
        return view('payment.trash');
    }

    public function getTrashPayment(Request $request)
    {
        $payments = Payment::onlyTrashed()->select('*');
        return DataTables::of($payments)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<form action="' . route('dashboard.payment.restore', ['id' => $row->id]) . '" method="POST" style="display:inline;">';
                $actionBtn .= csrf_field() . method_field('PATCH');
                $actionBtn .= '<button type="submit" class="btn btn-success btn-sm me-2">restore</button></form>';
                $actionBtn .= '<form action="' . route('dashboard.payment.delete_permanent', ['id' => $row->id]) . '" method="POST" style="display:inline;">';
                $actionBtn .= csrf_field() . method_field('DELETE');
                $actionBtn .= '<button type="submit" onclick="return confirm(\'Are you sure to delete permanently?\')" class="btn btn-danger btn-sm">Delete Permanent</button></form>';
                return $actionBtn;
            })
            // ->filter(function ($query) use ($request) {
            //     if ($request->get('search')['value']) {
            //         $searchValue = $request->get('search')['value'];
            //         $query->where(function($query) use ($searchValue) {
            //             $query->where('type_payment', 'like', "%{$searchValue}%");
            //         });
            //     }
            // })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function restore($id)
    {
        $payments = Payment::onlyTrashed()->find($id);
        $payments->restore();

        return redirect()->route('dashboard.payment.index')->with('success', 'Successfully restore data!');
    }

    public function deletePermanent($id)
    {
        $payments = Payment::onlyTrashed()->find($id);
        $payments->forceDelete();

        return redirect()->route('dashboard.payment.index')->with('success', 'Successfully delete permanent data!');
    }

    public function payment(Request $request)
    {
        $finalTotal = $request->final_total;
        $promoId = $request->final_promo_id;
        $paymentMethod = $request->payment_id;
        $invoice = 'INV-' . strtoupper(uniqid());
        $userId = auth()->id();
        $promoValue = null;
        if ($promoId) {
            $promo = Promo::find($promoId);
            $promoValue = $promo ? $promo->percent : null;
        }
        $virtual = null;

        if ($paymentMethod === 'BRI') {

            $virtual = '7777' . rand(1000000, 9999999);

        } elseif ($paymentMethod === 'BCA') {

            $virtual = '8800' . rand(1000000, 9999999);

        } elseif ($paymentMethod === 'QRIS') {

            if ($paymentMethod === 'QRIS') {
                $qrisData = json_encode([
                    'invoice' => $invoice,
                    'amount' => $finalTotal,
                    'user' => $userId,
                ]);

                $qrisSvg = QrCode::format('svg')->size(260)->generate($qrisData);
            }

        } else {

            $virtual = '9900' . rand(1000000, 9999999);
        }

        return view('payment', [
            'invoice' => $invoice,
            'date' => now()->format('Y-m-d'),
            'amount' => $finalTotal,
            'virtual' => $virtual,
            'userId' => $userId,
            'promoId' => $promoId,
            'promoValue' => $promoValue,
            'paymentMethod' => $paymentMethod,
            'qrisSvg' => $qrisSvg ?? null,
        ]);

    }

    public function finishPayment(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);
        $file = $request->file('payment_proof');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('payment/proof', $filename, 'public');

        $invoice = $request->invoice;
        $paymentId = $request->payment_method;

        $transaction = Transaction::create([
            'no' => $invoice,
            'user_id' => auth()->id(),
            'promo_id' => $request->promo_id ?? null,
            'total' => $request->amount,
            'promo' => $request->promo_value ?? 0,
            'sub_total' => $request->amount,
            'payment_id' => $paymentId,
            'attachment' => $path,
        ]);


        foreach (session('cart') as $ticketId => $item) {
            DetailTransaction::create([
                'no_transaction' => $invoice,
                'ticket_id' => $ticketId,
                'date' => session('visit_date'),
                'qty' => $item['qty'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('paymentSuccess', $invoice);
    }

    public function success($invoice)
    {
        $transaction = Transaction::where('no', $invoice)
            ->with(['details.ticket'])
            ->firstOrFail();

        return view('paymentSuccess', compact('transaction'));
    }


    public function exportPdf($invoice)
    {
        $transaction = Transaction::where('no', $invoice)
            ->with(['details.ticket', 'user', 'payment', 'promo'])
            ->first()
            ->toArray();

        view()->share('transaction', $transaction);

        $pdf = Pdf::loadView('pdf', $transaction)
            ->setPaper('A4', 'portrait');

        $fileName = 'Proof of Ticket Purchase.pdf';
        return $pdf->download($fileName);
    }




}

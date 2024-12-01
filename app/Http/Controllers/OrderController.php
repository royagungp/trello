<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Naspad;
use Illuminate\Http\Request;
use  Barryvdh\DomPDF\Facade\PDF as Dompdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $orders = Order::with('user')->simplePaginate(5);
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $naspads = Naspad::all();
        return view('order.create', compact('naspads'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_customer' => 'required',
            'naspads' => 'required',
        ]);
        $hitungJumlahDuplikat = array_count_values($request->naspads);
        $array_format = [];
        foreach ($hitungJumlahDuplikat as $key => $value) {
            $detailMenu = Naspad::find($key);

            if ($detailMenu['porsi'] < $value) {
                $msg = 'Tidak dapat membeli menu ini ' . $detailMenu['name'] . ' sisa porsi ' . $detailMenu['porsi'];
                return redirect()->back()->withInput()->with('failed', $msg);
            }

            $formatMenu = [
                "id" => $key,
                "name_naspads" => $detailMenu['name'],
                "qty" => $value,
                "price" => $detailMenu['price'],
                "sub_price" => $detailMenu['price'],
            ];
            array_push($array_format, $formatMenu);
        }
        $totalHarga = 0;
        foreach ($array_format as $key => $value) {
            $totalHarga += $value['sub_price'];

            $tambahOrder = Order::create([
                'user_id' => Auth::user()->id,
                'naspads' => $array_format,
                'name_customer' => $request->name_customer,
                'total_price' => $totalHarga,
            ]);

            if ($tambahOrder) {

                foreach ($array_format as $key => $value) {
                    $menuSebelumnya = Naspad::find($value['id']);
                    Naspad::where('id', $value['id'])->update(['porsi' => ($menuSebelumnya['porsi'] - $value['qty'])]);
                }
                return redirect()->route('orders.show', $tambahOrder['id'])->with('success', 'berhasil membuat pembelian!');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order, $id)
    {
        //
        $order = Order::find($id);
        return view('order.print', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function downloadPDF($id)
    {
            $order = Order::find($id)->toArray();
            view()->share('order', $order);
            $pdf = Dompdf::loadView('order.download-pdf',$order);
            return $pdf->download('invoice.pdf');
    }

    public function indexAdmin()
    {
        $orders = Order::with('user')->simplePaginate(10);
        return view("order.rekap-data", compact("orders"));
    }

    public function exportExcel(){
        return Excel::download(New OrderExport,'rekap_pembelian.xlsx');
    }
}

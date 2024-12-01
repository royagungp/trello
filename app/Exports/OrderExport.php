<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Order::with('user')->get();
    }

    public function headings(): array
    {
        return [
            "#",
            "Menu",
            "Total Harga",
            "Nama Kasir",
            "Waktu Pembelian"
        ];
    }
    public function map($order): array
    {
        $daftarMenu = "";
        foreach ($order->naspads as $key => $value) {
            $daftarMenu .= $key + 1 . "." . $value['name_naspads'] . " : " . $value['qty'] . " (pcs) Rp. " . number_format($value['sub_price'], 0, ',', '.');
        }
        return [
            $order->id,
            $order->user->name,
            $daftarMenu,
            $order->name_customer,
            "Rp. " . number_format($order->total_price, 0, ',', '.'),
            \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i')
        ];
    }
}

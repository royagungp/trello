@extends('templates.app', ['title' => 'Landing || Login'])

@section('content-dinamis')
    <div class="my-3">
        <!-- Form Pencarian Berdasarkan Tanggal Pembelian (dd/mm/yyyy) -->
        <form action="{{ route('orders') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="date" class="form-control" placeholder="Cari Tanggal (dd/mm/yyyy)"
                        value="{{ request()->input('date') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
        <div class="d-flex justify-content-end ">
            <a href="{{route('orders.export.excel')}}" class="btn btn-success">Export excel</a>
        </div>
        <table class="table table-bordered table-stripped text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu pembelian</th>
                    <th>Nama Pembeli</th>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Nama Kasir</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($orders as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}</td>
                        <td>{{ $item['name_customer'] }}</td>
                        <td>
                            @foreach ($item['naspads'] as $naspads)
                            <ol>
                                <li>
                                    {{-- mengakses key array assoc dari tiap item array value colums naspads --}}
                                    {{ $naspads['name_naspads'] }} {
                                    {{ number_format($naspads['price'], 0, ',', '.') }} } : Rp.
                                    {{ number_format($naspads['sub_price'], 0, ',', '.') }} <small>
                                        {{ $naspads['qty'] }} pcs</small>
                                </li>
                            </ol>
                        @endforeach

                        </td>
                        <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                        <td>{{ $item->user->name }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endsection

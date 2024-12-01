@extends('templates.app', ['title' => 'Landing || Login'])

@section('content-dinamis')
    <div class="my-3">
        <a href="{{ route('orders.create') }}" class="btn btn-success mb-3">+ Tambah</a>
        @if (Session::get('berhasil'))
            <div class="alert alert-success my-2">{{ Session::get('berhasil') }}</div>
        @endif
        <!-- Form Pencarian Berdasarkan Tanggal Pembelian (dd/mm/yyyy) -->
        <form action="{{ route('orders') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="date" class="form-control" placeholder="Cari Tanggal (d/m/yyyy)"
                        value="{{ request()->input('date') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-stripped text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Waktu pembelian</th>
                        <th>Nama Pembeli</th>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Nama Kasir</th>
                        <th>Aksi</th>
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
                            <td class="d-flex justify-content-center py-1">
                                <a href="{{ route('orders.download', $item['id']) }}" class="btn btn-warning">Cetak</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

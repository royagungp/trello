@extends('templates.app', ['title' => 'Add Order || NASPAD'])
@section('content-dinamis')
    <div class="container mt-3">
        <form action="{{ route('orders.store') }}"class="card m-auto p-5" method="POST">
            @csrf
            {{-- validate error massage --}}
            @if ($errors->any())
                <ul class="alert alert-danger p-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @if (Session::get('failed'))
                <div class="alert alert-danger">{{ Session::get('failed') }}</div>
            @endif
            <p>Penanggung Jawab: <b>{{ Auth::user()->name }}</b></p>
            <div class="mb-3 row">
                <label for="name_customer" class="col-sm-2 col-form-label">Nama Pembeli</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name_customer" name="name_customer">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="naspads" class="col-sm-2 col-form-label">Menu</label>
                <div class="col-sm-10">
                    {{-- name dibuat array karena nantinya data obat {naspads} akan berbentuk array/data bisa lebih dari satu --}}
                    <select name="naspads[]" id="naspads" class="form-select">
                        <option selected hidden disabled>Pesanan 1</option>
                        @foreach ($naspads as $item)
                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    {{-- div pembungkus untuk tambahan select yg akan muncul --}}
                    <div id="wrap-naspads"></div>
                    <br>
                    <p style="cursor: pointer" class="text-primary" id="add-select">+ Tambah Menu</p>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Konfirmasi Pembelian</button>
        </form>
    </div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        // definisikan no sebagai 2
        let no = 2;
        $("#add-select").on("click", function() {
            // tag html yg akan di tambahkan 
            let el= `<br><select name="naspads[]" id="naspads" class="form-select">
                        <option selected hidden disabled>Pesanan ${no}</option>
                        @foreach ($naspads as $item)
                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                        @endforeach
                    </select>`;
                    // append : tambahkan element html dibagian sblm penutup tag penutup terkait (sblm penutup tag yg id nya warp-naspads)
                    $("#wrap-naspads").append(el);
                    // increment variable no agar angka yg muncul di option selalu bertambah 1 sesuai jumlah select yg di tambahkan
                    no++; 
        });
    </script>
@endpush

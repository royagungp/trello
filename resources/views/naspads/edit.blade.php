@extends('templates.app', ['title' => 'Edit Akun || NASPAD'])

@section('content-dinamis')
{{-- action route mengirim $item['id'] untuk spesifikasi data di route path {id} --}}
@if (Session::get('failed'))
    <div class="alert alert-danger">{{ Session::get('failed') }}</div>
@endif
    <form action="{{ route('naspads.edit.update', $naspad['id']) }}" method="POST">
        @csrf
        {{-- patch : http method route untuk ubah data --}}
        @method('PATCH')
        <div class="form-group mb-3">
            <label for="name" class="form-label">Nama Mamin</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $naspad['name'] }}">
        </div>
        {{-- jika ada error validasi berhubungan dengan name, tampilkan dibawah input name text merah --}}
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        <div class="form-group mb-3">
            <label for="type" class="form-label">Tipe Mamin</label>
            <select name="type" id="type" class="form-select">
                <option value="minuman" {{ $naspad['type'] == 'minuman' ? 'selected' : '' }}>minuman</option>
                <option value="makanan" {{ $naspad['type'] == 'makanan' ? 'selected' : '' }}>makanan</option>
            </select>
        </div>
        @error('type')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        <div class="form-group mb-3">
            <label for="price" class="form-label">Harga menu</label>
            {{-- $naspad dari compact, yg mengambil first() data yg mau diedit --}}
            <input type="number" class="form-control" id="price" name="price" value="{{ $naspad['price'] }}">
        </div>
        @error('price')
        {{-- $message : memunculkan error terkait dengan price --}}
            <small class="text-danger">{{ $message }}</small>
        @enderror
        <div class="form-group mb-3">
            <label for="porsi" class="form-label">Porsi</label>
            <input type="number" class="form-control" id="porsi" name="porsi" value="{{ $naspad['porsi'] }}">
        </div>
        @error('porsi')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        <button type="submit" class="btn btn-primary">Ubah Data</button>
    </form>
@endsection
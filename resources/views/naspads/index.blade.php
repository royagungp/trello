@extends('templates.app', ['title' => 'mamin || NASPAD'])

@section('content-dinamis')
    <a href="{{ route('naspads.add') }}" class="btn btn-success mb-3">+ Tambah Menu</a>

@if(Session::get('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Tipe</th>
                    <th>Harga</th>
                    <th>Jumlah Porsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (count($naspads) > 0)
                    @foreach ($naspads as $index => $item)
                        <tr>
                            <td>{{ ($naspads->currentPage() - 1) * $naspads->perPage() + ($index + 1) }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="{{ $item['porsi'] <= 3 ? 'bg-danger text-white' : 'bg-white text-dark' }}"
                                onclick="editPorsi({{ $item['id'] }}, {{ $item['porsi']}})">
                                <span style="cursor: pointer; text decoration: underline ! importand"> {{ $item['porsi'] }}</span>
                            </td>
                            <td class="d-flex justify-content-center py-1">
                                {{--Karna edit ada path dinamis {id} --}}
                                <a href="{{route('naspads.edit', $item['id'])}}" class="btn btn-primary btn-sm me-2">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="showModal('{{ $item->id}}', '{{ $item->name}}')">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data</td> 
                    </tr>
                @endif
        </tbody>
        </table>
    </div>  

    <div class="d-flex justify-content-end mt-3">
        {{ $naspads->links() }}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-delete-mamin" method="POST">
                @csrf
                {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
                method untul menghapus data---}}
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data mamin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus mamin <span id="nama-obat"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-danger" id="confirm-delete">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

        <div class="modal fade" id="editPorsikModal" tabindex="-1" aria-labelledby="editPorsiLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="form-edit-porsi" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPorsiLabel">Edit Porsi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="naspad-id">
                            <div class="form-group">
                                <label for="porsi" class="form-label">Porsi</label>
                                <input type="number" name="porsi" id="porsi" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>
    <script>
        //fungsi untuk menampilkan modal
        function showModal(id, name) {
            //isi untuk action form
            let action='{{ route("naspads.delete", ":id") }}';
            action = action.replace(':id', id);
            //buat attribute action pada form
            $('#form-delete-mamin').attr('action', action);
            //munculkan modal yang id nya exampleModal
            $('#exampleModal').modal('show');
            //innerText pada element html id nama-obat
            console.log(name);
            $('#nama-mamin').text(name);
        }

        //fungsi untuk menampilkan modal edit porsi sama masukin nilai stock yang mau di edit
        function editPorsi(id, porsi) {
            $('#naspad-id').val(id);
            $('#porsi').val(porsi);
            $('#editStockModal').modal('show');
        }

        //event listener buat handle submit form secara AJAX
        $('#form-edit-porsi').on('submit', function(e) {
            //biar form gak ke-submit dengan cara biasa (refresh halaman)
            e.preventDefault();
            //Ambil id obat dari input hidden
            let id = $('#naspad-id').val();
            //Ambil porsi baru yang di input user
            let porsi = $('#porsi').val();
            //Bikin URL buat update porsi dengan metode PUT
            let actionUrl = "{{ url('/naspads/update-porsi') }}/" + id;
            //Kirim request AJAX buat update porsi
            $.ajax({
                url:actionUrl,//URL tujuan buat update porsi
                type:'PUT', // Gunakan metode PUT buat update data
                data: {
                    _token: "{{ csrf_token() }}", //Token CSRF biar aman
                    porsi: porsi // Data porsi baru yang mau di kirim ke Server(Database)
                },
                success: function(response) {
                    //Tutup modal kalau update berhasil
                    $('#editPorsikModal').modal('hide');
                    //Refresh halaman biar perubahan porsi keliatan
                    alert('berhasil update porsi')
                    location.reload();
                },
                error: function(err) {
                    //Tutup modal kalau update gagal
                    // alert('Ada masalah waktu update porsi');
                    // console.log(xhr.responseText);
                    alert(err.responseJSON.failed);
                }
            });
        });
    </script>
@endpush
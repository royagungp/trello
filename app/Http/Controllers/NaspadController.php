<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// import Model
use App\Models\Naspad;

class NaspadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $naspads = Naspad::where('name', 'LIKE', '%'.$request->search.'%')->orderBy('name','ASC')->simplePaginate(5);
          // compact : mengirim data ke blade : compact('namavariable')
        return view('naspads.index', compact('naspads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('naspads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required|min:5|max:15',
            'price' => 'required|numeric',
            'porsi' => 'required',
        ], [
            'type.required' => 'Jenis mamin wajib diisi!',
            'name.required' => 'Nama mamin wajib diisi!',
            'price.required' => 'Harga mamin wajib diisi!',
            'price.numeric' => 'Harga mamin harus berupa angka!',
            'porsi.required' => 'Jumlah porsi wajib diisi!',
        ]);
        $proses = Naspad::create([
            'type' => $request->type,
            'name' => $request->name,
            'price' => $request->price,
            'porsi' => $request->porsi,
        ]);
        if ($proses) {
            return redirect()->route('naspads')->with('success', 'Data naspad berhasil ditambahkan');
        } else {
            return redirect()->route('naspads.add')->with('failed', 'Gagal menambahkan data naspad');
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
    public function edit($id)
    {
          //ambil data yg mau di edit sesuai dengan id {id}
        // where() : mencari berdasarkan id
        // first() : mengambil data pertama (satu data yg diambil)
        $naspad = Naspad::where('id', $id)->first();
        return view('naspads.edit', compact('naspad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required|min:5|max:15',
            'price' => 'required|numeric',
            'porsi' => 'required',
        ], [
            'type.required' => 'Jenis mamin wajib diisi!',
            'name.required' => 'Nama mamin wajib diisi!',
            'price.required' => 'Harga mamin wajib diisi!',
            'price.numeric' => 'Harga mamin harus berupa angka!',
            'porsi.required' => 'Jumlah porsi wajib diisi!',
        ]);
        // ambil data sebelumnya, ambil dr id yg dikirim route {id}
        $naspadBefore = Naspad::where('id', $id)->first();
        // cek isi input stock jangan lebih kecil dari stock yg uda ada sebelumnya
        if ((int)$request->porsi < (int)$naspadBefore->porsi) {
            return redirect()->back()->with('failed', 'Jumlah porsi baru tidak boleh kurang dari jumlah sebelumnya!');
        }
        // kalau stok >= dari sebelumnya, data diupdate
        $proses = $naspadBefore->update([
            'type' => $request->type,
            'name' => $request->name,
            'price' => $request->price,
            'porsi' => $request->porsi,
        ]);
        if ($proses) {
            return redirect()->route('naspads')->with('success', 'Data naspad berhasil diubah!');
        } else {
            return redirect()->route('naspads.edit', $id)->with('failed', 'Gagal mengubah data mamin!');
        }
    }
    public function porsiEdit(Request $request, $id)
    {
        if(!isset($request->porsi)){
            return response()->json(['failed'=> 'Jumlah por tidak boleh kosong'], 400);
        }
        $naspad = Naspad::findOrFail($id);
        $naspad->update(['porsi'=>$request->porsi]);
        // $naspad->porsi = $request->input('porsi');
        // $naspad->save();

        return response()->json(['success' => 'Jumlah porsi berhasil diupdate']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         // mencari data yg akan dihapus dengan where, lalu hapus dengan delete()
         $proses = Naspad::where('id', $id)->delete();
         if ($proses) {
             // redirect()->back() : kembali ke halaman sebelum destroy dijalanin (halaman button delete berada)
             return redirect()->back()->with('success', 'Data naspad berhasil dihapus!');
         } else {
             return redirect()->back()->with('failed', 'Gagal menghapus data naspad!');
         }
    }
}

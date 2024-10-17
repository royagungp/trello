<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
        // menampilkan banyak data atau halaman awal fitur
        public function index()
        {
            // view() : memanggil file blade di folder resources/views
            // tanda . digunakan untuk sub folder
            // gunakan kebab case
            return view('landing_page');
        }
    
        // menampilkan formulir untuk membuat data baru
        public function create()
        {
            //
        }
    
        // menyimpan data baru ke database
        public function store(Request $request)
        {
            //
        }
    
        // menampilkan hanya satu data
        public function show(string $id)
        {
            //
        }
    
        // menampilkan formulir untuk edit data
        public function edit(string $id)
        {
            //
        }
    
        // mengubah data ke database
        public function update(Request $request, string $id)
        {
            //
        }
    
        // menghapus data di database
        public function destroy(string $id)
        {
            //
        }
    }
    


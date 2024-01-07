<?php

namespace App\Http\Controllers;

use App\Models\buku;
use App\Models\kategori;
use Illuminate\Http\Request;

class Route_Controller extends Controller
{
    public function dashboard()
    {
        $userRole = session('role'); // Assuming the session variable for role is 'role'

        if ($userRole == 'admin') {
            $buku = buku::all();
        } else {
            $buku = buku::where('uploaded_by', session('name'))->get();
        }

        $kategori = kategori::all();
        return view('pages.dashboard.main', ['buku' => $buku, 'kategori' => $kategori]);
    }


    public function login()
    {
        return view('pages.auth.login');
    }

    public function register()
    {
        return view('pages.auth.register');
    }


    public function tambahbuku()
    {
        $kategori = kategori::all();
        return view('pages.dashboard.tambahbuku', ['kategori' => $kategori]);
    }

    public function datakategori()
    {
        $kategori = kategori::all();
        return view('pages.dashboard.datakategori', ['kategori' => $kategori]);
    }

    public function editbuku($judul_buku)
    {
        $kategori = kategori::all();
        $buku = buku::where('judul_buku', $judul_buku)->first();
        return view('pages.dashboard.editbuku', ['kategori' => $kategori, 'buku' => $buku]);
    }
}

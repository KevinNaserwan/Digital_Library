<?php

namespace App\Http\Controllers;

use App\Models\buku;
use App\Models\kategori;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DigitalLabController extends Controller
{
    public function storekategori(Request $request)
    {
        // Validasi input
        $request->validate([
            'kategori_buku' => 'required|string|max:255',
        ]);

        kategori::create([
            'kategori_buku' => $request->input('kategori_buku'),
        ]);

        return redirect()->back()->with('success', 'Berhasil Menambah Kategori');
    }

    public function storebuku(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul_buku' => 'required|string|max:255|unique:buku,judul_buku',
            'kategori_buku' => 'required',
            'jumlah' => 'required|integer',
            'deskripsi' => 'required|string',
            'file_buku' => 'required|mimes:pdf',
            'cover_buku' => 'required|mimes:jpeg,jpg,png',
        ]);

        //Route Lokasi Penyimpanan di public
        $fileBukuPath = $request->file_buku->storeAs('public/files', $request->judul_buku . '.' . $request->file_buku->getClientOriginalExtension());
        $coverBukuPath = $request->cover_buku->storeAs('public/covers', $request->judul_buku . '.' . $request->cover_buku->getClientOriginalExtension());


        $file = $request->file('file_buku');
        $nama_file = $request->input('judul_buku') . "." . $request->file('file_buku')->getClientOriginalExtension();
        $file->move(public_path('file_buku'), $nama_file);

        $cover = $request->file('cover_buku');
        $cover_buku = $request->input('judul_buku') . "." . $request->file('cover_buku')->getClientOriginalExtension();
        $cover->move(public_path('cover_buku'), $cover_buku);

        // Simpan data ke Model Buku
        buku::create([
            'judul_buku' => $request->input('judul_buku'),
            'kategori_buku' => $request->input('kategori_buku'),
            'jumlah' => $request->input('jumlah'),
            'deskripsi' => $request->input('deskripsi'),
            'file_buku' => $nama_file,
            'cover_buku' => $cover_buku,
            'uploaded_by' => session('name')
        ]);

        // Return Jika berhasil
        return redirect()->route('dashboard')->with('success', 'Berhasil Menambahkan Buku');
    }


    public function delete($judul_buku)
    {
        $user = Auth::user(); // Assuming you are using Laravel's built-in authentication

        $buku = buku::where('judul_buku', $judul_buku)->first();



        // Check if the user has the appropriate permissions
        if ($buku && (session('name') == $buku->uploaded_by || session('role') == 'admin')) {
            Storage::delete([
                'public/files/' . $buku->file_buku,
                'public/covers/' . $buku->cover_buku,
            ]);
            // User has permission, delete the record
            $buku->delete();
            return redirect()->route('dashboard')->with('success', 'Berhasil Hapus Data');
        } else {
            // User does not have permission, handle accordingly (e.g., show an error message)
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus data ini.');
        }
    }

    public function deletekategori($kategori_buku)
    {
        $buku = kategori::where('kategori_buku', $kategori_buku)->first();

        // User has permission, delete the record
        $buku->delete();
        return redirect()->back()->with('success', 'Berhasil Hapus Data');

    }

    public function updatekategori(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'kategori_buku' => 'required|string|max:255|unique:kategori,kategori_buku',
        ]);

        // Find the category by ID
        $kategori = Kategori::find($id);

        // Check if the category exists
        if ($kategori) {
            // Update all related books
            // $kategori->bukus()->update(['kategori_buku' => $request->input('kategori_buku')]);

            // Update the category
            $kategori->kategori_buku = $request->input('kategori_buku');
            $kategori->save();

            return redirect()->back()->with('success', 'Berhasil Mengupdate Kategori dan Buku Terkait');
        } else {
            // Category not found, handle accordingly (e.g., show an error message)
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }
    }


    public function updatebuku(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'judul_buku' => 'string|max:255|unique:buku,judul_buku',
            'kategori_buku' => '',
            'jumlah' => 'integer',
            'deskripsi' => 'string',
            'file_buku' => 'nullable|mimes:pdf',
            'cover_buku' => 'nullable|mimes:jpeg,jpg,png',
        ]);

        // Retrieve the book to update
        $buku = buku::where('id', $id)->first();

        if (!$buku) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan');
        }

        // Delete old files
        Storage::delete([
            'public/files/' . $buku->file_buku,
            'public/covers/' . $buku->cover_buku,
        ]);

        // Upload new files
        if ($request->hasFile('file_buku')) {
            $file = $request->file('file_buku');
            $nama_file = $request->input('judul_buku') . "." . $request->file('file_buku')->getClientOriginalExtension();
            $file->move(public_path('file_buku'), $nama_file);
            $buku->file_buku = $request->judul_buku . '.' . $request->file_buku->getClientOriginalExtension();
        }

        if ($request->hasFile('cover_buku')) {
            $cover = $request->file('cover_buku');
            $cover_buku = $request->input('judul_buku') . "." . $request->file('cover_buku')->getClientOriginalExtension();
            $cover->move(public_path('cover_buku'), $cover_buku);
            $buku->cover_buku = $request->judul_buku . '.' . $request->cover_buku->getClientOriginalExtension();
        }

        // Update book data
        $buku->judul_buku = $request->input('judul_buku');
        $buku->kategori_buku = $request->input('kategori_buku');
        $buku->jumlah = $request->input('jumlah');
        $buku->deskripsi = $request->input('deskripsi');
        $buku->uploaded_by = session('name');
        $buku->save();

        // Return if successful
        return redirect()->route('dashboard')->with('success', 'Berhasil Memperbarui Buku');
    }

    public function exportToPdf()
    {
        $buku = buku::all();

        $pdf = Pdf::loadView('exports.buku_pdf', ['buku' => $buku]);

        return $pdf->download('buku.pdf');
    }





}

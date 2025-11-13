<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran; // Mengimpor model Pengeluaran

class PengeluaranController extends Controller
{
    /**
     * Menampilkan daftar pengeluaran.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua data dari tabel pengeluaran
        $data_pengeluaran = Pengeluaran::all();

        // Mengirim data ke view 'expense' dan menampilkannya
        return view('expense', ['data_pengeluaran' => $data_pengeluaran]);
    }

    /**
     * Menyimpan data pengeluaran baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'jumlah_pengeluaran' => 'required|numeric',
            'tanggal_pengeluaran' => 'required|date',
        ]);

        $pengeluaran = new Pengeluaran;
        $pengeluaran->keterangan = $request->keterangan;
        $pengeluaran->jumlah_pengeluaran = $request->jumlah_pengeluaran;
        $pengeluaran->tanggal_pengeluaran = $request->tanggal_pengeluaran;
        $pengeluaran->save();

        return response()->json(['success' => true, 'message' => 'Data pengeluaran berhasil ditambahkan.']);
    }

    /**
     * Menampilkan data pengeluaran spesifik.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Pengeluaran $pengeluaran)
    {
        return response()->json($pengeluaran);
    }

    /**
     * Memperbarui data pengeluaran di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'jumlah_pengeluaran' => 'required|numeric',
            'tanggal_pengeluaran' => 'required|date',
        ]);

        $pengeluaran->keterangan = $request->keterangan;
        $pengeluaran->jumlah_pengeluaran = $request->jumlah_pengeluaran;
        $pengeluaran->tanggal_pengeluaran = $request->tanggal_pengeluaran;
        $pengeluaran->save();

        return response()->json(['success' => true, 'message' => 'Data pengeluaran berhasil diperbarui.']);
    }

    /**
     * Menghapus data pengeluaran dari database.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();
        return response()->json(['success' => true, 'message' => 'Data pengeluaran berhasil dihapus.']);
    }
}
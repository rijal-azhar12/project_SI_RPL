<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TransaksiDetail;
use App\Models\Menu;
use Carbon\Carbon;

class IncomeController extends Controller
{
    /**
     * Menampilkan halaman manajemen pendapatan (incomes).
     */
    public function index(Request $request)
    {
        $user = Auth::user(); // $user akan menjadi NULL jika tidak ada login, dan itu tidak apa-apa
        $filter = $request->input('filter', 'Month'); // Default filter 'Month'
        $now = Carbon::now();

        // Tentukan rentang tanggal berdasarkan filter
        if ($filter == 'Day') {
            $startDate = $now->copy()->startOfDay();
            $endDate = $now->copy()->endOfDay();
        } elseif ($filter == 'Week') {
            $startDate = $now->copy()->startOfWeek();
            $endDate = $now->copy()->endOfWeek();
        } else { // Default 'Month'
            $startDate = $now->copy()->startOfMonth();
            $endDate = $now->copy()->endOfMonth();
        }

        // --- 1. MEMBUAT KUERI DASAR (BASE QUERY) ---
        // Kueri dasar dimulai dari TransaksiDetail
        $baseQuery = TransaksiDetail::query()
            ->join('transaksi', 'transaksi_detail.id_transaksi', '=', 'transaksi.id_transaksi')
            ->whereBetween('transaksi.tanggal_transaksi', [$startDate, $endDate]);

        // Filter berdasarkan peran: 'kasir' hanya lihat data sendiri, 'owner' lihat semua
        
        // --- PERBAIKAN DI SINI ---
        // Kita cek dulu $user ADA (tidak null), baru cek perannya.
        if ($user && $user->peran == 'kasir') {
            $baseQuery->where('transaksi.id_user', $user->id_user);
        }
        // Jika $user null (tidak login), if() ini akan di-skip, 
        // dan Anda akan melihat data sebagai 'owner' (melihat semua).

        // --- 2. MENGHITUNG STATISTIK (DARI KUERI DASAR) ---

        // A. Total Revenue
        $totalRevenue = $baseQuery->clone()->sum('transaksi_detail.subtotal');

        // B. Total Units Sold
        $totalUnitsSold = $baseQuery->clone()->sum('transaksi_detail.jumlah_item');

        // C. Top Selling Item
        $topSellingItem = $baseQuery->clone()
            ->join('menu', 'transaksi_detail.id_menu', '=', 'menu.id_menu')
            ->select('menu.nama_menu', DB::raw('SUM(transaksi_detail.jumlah_item) as total_terjual'))
            ->groupBy('transaksi_detail.id_menu', 'menu.nama_menu') // Grup berdasarkan ID dan Nama
            ->orderByDesc('total_terjual')
            ->first(); // Ambil yang paling atas

        // --- 3. MENGAMBIL DATA UNTUK TABEL (DARI KUERI DASAR) ---
        
        // Buat kueri baru untuk list tabel agar bisa pakai Eloquent 'with'
        $tableQuery = TransaksiDetail::with(['transaksi.user', 'menu'])
            ->whereHas('transaksi', function ($q) use ($startDate, $endDate, $user) {
                $q->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
                
                // Filter kasir lagi di sini untuk relasi
                
                // --- PERBAIKAN KEDUA DI SINI ---
                // Kita juga perlu cek $user && ... di dalam 'whereHas'
                if ($user && $user->peran == 'kasir') {
                    $q->where('id_user', $user->id_user);
                }
            });

        $incomes = $tableQuery->orderByDesc('id_detail')->paginate(10); // Ambil 10 data per halaman

        // --- 4. KIRIM DATA KE VIEW ---
        // Ini sudah benar merujuk ke 'pemasukan'
        return view('pemasukan', [ 
            'totalRevenue' => $totalRevenue,
            'totalUnitsSold' => $totalUnitsSold,
            'topSellingItem' => $topSellingItem,
            'incomes' => $incomes,
            'filter' => $filter, 
            'filterPeriod' => $startDate->format('d M') . ' - ' . $endDate->format('d M Y')
        ]);
    }

    /**
     * Menghapus data pendapatan (transaksi_detail).
     */
    public function destroy($id_detail)
    {
        try {
            // Temukan detail transaksi
            $transaksiDetail = TransaksiDetail::findOrFail($id_detail);
            
            // (Opsional) Cek otorisasi jika perlu:
            $user = Auth::user(); // Ambil user (bisa null)
            
            // --- PERBAIKAN KETIGA (PREVENTIF) ---
            // Saya perbaiki juga di dalam komentar, jika nanti Anda aktifkan.
            // if ($user && $user->peran == 'kasir' && $transaksiDetail->transaksi->id_user != $user->id_user) {
            //     return response()->json(['message' => 'Unauthorized'], 403);
            // }

            $transaksiDetail->delete();

            return response()->json(['message' => 'Income record deleted successfully.']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting record.'], 500);
        }
    }
}
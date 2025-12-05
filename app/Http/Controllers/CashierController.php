<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    public function index()
    {
        $menus = Menu::all()->groupBy('kategori_menu');
        return view('cashier', compact('menus'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|json',
            'total' => 'required|numeric',
        ]);

        date_default_timezone_set('Asia/Jakarta');

        DB::beginTransaction();
        try {
            $transaksi = new Transaksi();
            $transaksi->id_user = Auth::id();
            $transaksi->tanggal_transaksi = now();
            $transaksi->save();
            $id_transaksi = $transaksi->id_transaksi;

            $items = json_decode($request->items, true);

            foreach ($items as $item) {
                $menu = Menu::find($item['id_menu']);
                if (!$menu || $menu->stok_menu < $item['quantity']) {
                    throw new \Exception('Stok tidak mencukupi untuk ' . $item['nama_menu']);
                }

                $transaksiDetail = new TransaksiDetail();
                $transaksiDetail->id_detail = $id_transaksi . $item['id_menu'];
                $transaksiDetail->id_transaksi = $id_transaksi;
                $transaksiDetail->id_menu = $item['id_menu'];
                $transaksiDetail->jumlah_item = $item['quantity'];
                $transaksiDetail->subtotal = $item['harga_menu'] * $item['quantity'];
                $transaksiDetail->total = $request->total;
                $transaksiDetail->save();

                $menu->stok_menu -= $item['quantity'];
                $menu->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal: ' . $e->getMessage()
            ], 500);
        }
    }
}

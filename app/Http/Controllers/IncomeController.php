<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Menu;
use App\Models\User;
use Carbon\Carbon;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->input('filter', 'Month');
        $now = Carbon::now();

        if ($filter == 'Day') {
            $startDate = $now->copy()->startOfDay();
            $endDate = $now->copy()->endOfDay();
        } elseif ($filter == 'Week') {
            $startDate = $now->copy()->startOfWeek();
            $endDate = $now->copy()->endOfWeek();
        } else {
            $startDate = $now->copy()->startOfMonth();
            $endDate = $now->copy()->endOfMonth();
        }

        $statsQuery = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        if ($user && $user->peran == 'kasir') {
            $statsQuery->where('id_user', $user->id_user);
        }
        $transaksiForStats = $statsQuery->with('details.menu')->get();

        $totalRevenue = 0;
        $totalUnitsSold = 0;
        $topSellingItems = [];
        foreach ($transaksiForStats as $tr) {
            foreach ($tr->details as $detail) {
                $totalRevenue += $detail->subtotal;
                $totalUnitsSold += $detail->jumlah_item;
                $menuName = $detail->menu->nama_menu ?? 'Unknown Menu';
                $topSellingItems[$menuName] = ($topSellingItems[$menuName] ?? 0) + $detail->jumlah_item;
            }
        }
        arsort($topSellingItems);
        $topSellingItem = null;
        if (!empty($topSellingItems)) {
            $topSellingItemName = array_key_first($topSellingItems);
            $topSellingItem = (object)['nama_menu' => $topSellingItemName, 'total_terjual' => $topSellingItems[$topSellingItemName]];
        }

        $incomesQuery = Transaksi::with(['user', 'details.menu']);
        if ($user && $user->peran == 'kasir') {
            $incomesQuery->where('id_user', $user->id_user);
        }
        $incomes = $incomesQuery->orderByDesc('tanggal_transaksi')->paginate(10);


        return view('income', [
            'totalRevenue' => $totalRevenue,
            'totalUnitsSold' => $totalUnitsSold,
            'topSellingItem' => $topSellingItem,
            'filter' => $filter,
            'filterPeriod' => $startDate->format('d M') . ' - ' . $endDate->format('d M Y'),

            'incomes' => $incomes,

            'users' => User::where('peran', 'kasir')->get(),
            'menusForForm' => Menu::all(),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('income.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'tanggal_transaksi' => 'required|date',
            'menu_items' => 'required|array|min:1',
            'menu_items.*.id_menu' => 'required|exists:menu,id_menu',
            'menu_items.*.jumlah_item' => 'required|integer|min:1',
        ]);

        $transaksi = Transaksi::create([
            'id_user' => $request->id_user,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        foreach ($request->menu_items as $item) {
            $menu = Menu::find($item['id_menu']);
            if ($menu) {
                TransaksiDetail::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_menu' => $menu->id_menu,
                    'jumlah_item' => $item['jumlah_item'],
                    'subtotal' => $item['jumlah_item'] * $menu->harga_menu, // Recalculate subtotal server-side
                ]);
            }
        }

        return redirect()->route('income.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Transaksi $income)
    {
        return redirect()->route('income.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $income)
    {
        return redirect()->route('income.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $income)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'tanggal_transaksi' => 'required|date',
            'menu_items' => 'required|array|min:1',
            'menu_items.*.id_detail' => 'nullable|exists:transaksi_detail,id_detail',
            'menu_items.*.id_menu' => 'required|exists:menu,id_menu',
            'menu_items.*.jumlah_item' => 'required|integer|min:1',
        ]);

        $income->update([
            'id_user' => $request->id_user,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        $existingDetailIds = $income->details->pluck('id_detail')->toArray();
        $updatedDetailIds = [];

        foreach ($request->menu_items as $item) {
            $menu = Menu::find($item['id_menu']);
            if (!$menu) continue;

            $detailData = [
                'id_transaksi' => $income->id_transaksi,
                'id_menu' => $menu->id_menu,
                'jumlah_item' => $item['jumlah_item'],
                'subtotal' => $item['jumlah_item'] * $menu->harga_menu,
            ];

            if (!empty($item['id_detail']) && in_array($item['id_detail'], $existingDetailIds)) {
                $detail = TransaksiDetail::find($item['id_detail']);
                $detail->update($detailData);
                $updatedDetailIds[] = (int)$item['id_detail'];
            } else {
                $newDetail = TransaksiDetail::create($detailData);
                $updatedDetailIds[] = $newDetail->id_detail;
            }
        }

        $detailsToDelete = array_diff($existingDetailIds, $updatedDetailIds);
        TransaksiDetail::whereIn('id_detail', $detailsToDelete)->delete();


        return redirect()->route('income.index')->with('success', 'Transaksi berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $income)
    {
        $income->details()->delete();
        $income->delete();

        return redirect()->route('income.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
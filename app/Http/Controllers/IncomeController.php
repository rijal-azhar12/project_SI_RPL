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

        $baseQuery = Transaksi::query()
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->with('user', 'details.menu');

        if ($user && $user->peran == 'kasir') {
            $baseQuery->where('id_user', $user->id_user);
        }

        $transaksiRecords = $baseQuery->get();

        // Initialize statistics
        $totalRevenue = 0;
        $totalUnitsSold = 0;
        $topSellingItems = [];

        foreach ($transaksiRecords as $tr) {
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

        $incomes = Transaksi::with('user', 'details.menu')
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate]);

        if ($user && $user->peran == 'kasir') {
            $incomes->where('id_user', $user->id_user);
        }

        $incomes = $incomes->orderByDesc('tanggal_transaksi')->paginate(10);

        return view('income', [
            'totalRevenue' => $totalRevenue,
            'totalUnitsSold' => $totalUnitsSold,
            'topSellingItem' => $topSellingItem,
            'incomes' => $incomes,
            'filter' => $filter,
            'filterPeriod' => $startDate->format('d M') . ' - ' . $endDate->format('d M Y'),
            'users' => User::where('peran', 'kasir')->get()
        ]);
    }

    public function create()
    {
        $users = User::where('peran', 'kasir')->get();
        return view('income_create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'tanggal_transaksi' => 'required|date',
            'menu_items' => 'array',
            'menu_items.*.id_menu' => 'required|exists:menu,id_menu',
            'menu_items.*.jumlah_item' => 'required|integer|min:1',
            'menu_items.*.harga_item' => 'required|numeric|min:0',
        ]);

        $transaksi = Transaksi::create([
            'id_user' => $request->id_user,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        if ($request->has('menu_items')) {
            foreach ($request->menu_items as $item) {
                $menu = Menu::find($item['id_menu']);
                if ($menu) {
                    TransaksiDetail::create([
                        'id_transaksi' => $transaksi->id_transaksi,
                        'id_menu' => $menu->id_menu,
                        'jumlah_item' => $item['jumlah_item'],
                        'harga_item' => $item['harga_item'],
                        'subtotal' => $item['jumlah_item'] * $item['harga_item'],
                    ]);
                }
            }
        }

        return redirect()->route('income.index')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function show(Transaksi $income)
    {
        return view('income_show', compact('income'));
    }

    public function edit(Transaksi $income)
    {
        $users = User::where('peran', 'kasir')->get();
        $menus = Menu::all();
        $income->load('details.menu');
        return view('income_edit', compact('income', 'users', 'menus'));
    }

    public function update(Request $request, Transaksi $income)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'tanggal_transaksi' => 'required|date',
            'menu_items' => 'array',
            'menu_items.*.id_detail' => 'nullable|exists:transaksi_detail,id_detail', // For existing details
            'menu_items.*.id_menu' => 'required|exists:menu,id_menu',
            'menu_items.*.jumlah_item' => 'required|integer|min:1',
            'menu_items.*.harga_item' => 'required|numeric|min:0',
        ]);

        $income->update([
            'id_user' => $request->id_user,
            'tanggal_transaksi' => $request->tanggal_transaksi,
        ]);

        $existingDetailIds = $income->details->pluck('id_detail')->toArray();
        $updatedDetailIds = [];

        if ($request->has('menu_items')) {
            foreach ($request->menu_items as $item) {
                if (isset($item['id_detail']) && $item['id_detail']) {
                    $detail = TransaksiDetail::find($item['id_detail']);
                    if ($detail && $detail->id_transaksi == $income->id_transaksi) {
                        $menu = Menu::find($item['id_menu']);
                        $detail->update([
                            'id_menu' => $menu->id_menu,
                            'jumlah_item' => $item['jumlah_item'],
                            'harga_item' => $item['harga_item'],
                            'subtotal' => $item['jumlah_item'] * $item['harga_item'],
                        ]);
                        $updatedDetailIds[] = $item['id_detail'];
                    }
                } else {
                    $menu = Menu::find($item['id_menu']);
                    if ($menu) {
                        $newDetail = TransaksiDetail::create([
                            'id_transaksi' => $income->id_transaksi,
                            'id_menu' => $menu->id_menu,
                            'jumlah_item' => $item['jumlah_item'],
                            'harga_item' => $item['harga_item'],
                            'subtotal' => $item['jumlah_item'] * $item['harga_item'],
                        ]);
                        $updatedDetailIds[] = $newDetail->id_detail;
                    }
                }
            }
        }

        $detailsToDelete = array_diff($existingDetailIds, $updatedDetailIds);
        TransaksiDetail::whereIn('id_detail', $detailsToDelete)->delete();


        return redirect()->route('income.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaksi $income)
    {
        try {
            $income->details()->delete();
            $income->delete();

            return response()->json(['message' => 'Transaksi record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting record.', 'error' => $e->getMessage()], 500);
        }
    }
}
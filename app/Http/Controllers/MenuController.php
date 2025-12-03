<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('menu', compact('menus'));
    }

    public function create()
    {
        return view('menu_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar_menu' => 'nullable|string',
            'nama_menu' => 'required|string|max:255',
            'stok_menu' => 'required|integer|min:0',
            'deskripsi_menu' => 'nullable|string',
            'kategori_menu' => 'required|string|max:255',
            'harga_menu' => 'required|numeric|min:0',
        ]);

        Menu::create($request->all());

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function show(Menu $menu) {}

    public function edit(Menu $menu)
    {
        return view('menu_edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'gambar_menu' => 'nullable|string',
            'nama_menu' => 'required|string|max:255',
            'stok_menu' => 'required|integer|min:0',
            'deskripsi_menu' => 'nullable|string',
            'kategori_menu' => 'required|string|max:255',
            'harga_menu' => 'required|numeric|min:0',
        ]);

        $menu->update($request->all());

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
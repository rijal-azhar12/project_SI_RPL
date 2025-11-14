<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
        return view('menu', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu_create'); // Anda bisa membuat view terpisah untuk form create
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        return view('menu_edit', compact('menu')); // Anda bisa membuat view terpisah untuk form edit
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuRequest;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * Menampilkan daftar semua item menu.
     */
    public function index(Request $request)
    {
        $menus = Menu::all();
        if ($request->wantsJson()) {
            return response()->json($menus);
        }
        return view('menus.index', compact('menus'));
    }

    /**
     * Menampilkan form untuk membuat menu baru.
     */
    public function create(): View
    {
        $categories = \App\Models\Category::all();
        return view('menus.create', compact('categories'));
    }

    /**
     * Menyimpan data menu baru ke database.
     */
    public function store(StoreMenuRequest $request)
    {
        $menu = Menu::create($request->validated());

        if ($request->wantsJson()) {
            return response()->json($menu, 201);
        }

        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail menu tertentu.
     */
    public function show(Request $request, Menu $menu)
    {
        if ($request->wantsJson()) {
            return response()->json($menu);
        }
        return view('menus.show', compact('menu'));
    }

    /**
     * Menampilkan form untuk mengubah data menu tertentu.
     */
    public function edit(Menu $menu): View
    {
        $categories = \App\Models\Category::all();
        return view('menus.edit', compact('menu', 'categories'));
    }

    /**
     * Memperbarui data menu tertentu di database.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|integer|min:0',
            'category' => 'required|string|max:100',
        ]);

        $menu->update($validated);

        if ($request->wantsJson()) {
            return response()->json($menu);
        }

        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Menghapus data menu tertentu dari database.
     */
    public function destroy(Request $request, Menu $menu)
    {
        $menu->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Success']);
        }

        return redirect()->route('menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}
<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreMenuRequest;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller {
    public function index(): View {
        $menus = Menu::all();
        return view('menus.index', compact('menus'));
    }
    public function create(): View {
        return view('menus.create');
    }
    public function store(StoreMenuRequest $request): RedirectResponse {
        Menu::create($request->validated());
        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }
    public function show(Menu $menu): View {
        return view('menus.show', compact('menu'));
    }
    public function edit(Menu $menu): View {
        return view('menus.edit', compact('menu'));
    }
    public function update(Request $request, Menu $menu): RedirectResponse {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|integer|min:0',
            'category' => 'required|string|max:100',
        ]);
        $menu->update($validated);
        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui.');
    }
    public function destroy(Menu $menu): RedirectResponse {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}
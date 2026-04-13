<?php

namespace App\Http\Controllers;

use App\Repositories\ItemRepository;
use Illuminate\Http\Request;

class ItemLibraryController extends Controller
{
    public function index(Request $request, ItemRepository $items)
    {
        $q = (string)$request->query('q', '');
        $category = $request->query('category');
        $category = is_string($category) && trim($category) !== '' ? $category : null;

        return view('items.index', [
            'items' => $items->search($q, $category),
            'categories' => $items->categories(),
            'q' => $q,
            'category' => $category,
        ]);
    }

    public function show(string $id, ItemRepository $items)
    {
        $item = $items->findById($id);
        abort_if(!$item, 404);

        return view('items.show', [
            'item' => $item,
        ]);
    }
}

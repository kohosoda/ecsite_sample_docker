<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // 商品を一覧表示する
    public function index()
    {
        $items = Item::paginate(6);

        return view('item.index', ['items' => $items]);
    }

    // 商品の詳細画面を表示する
    public function show(Item $item)
    {
        return view('item.show', ['item' => $item]);
    }

    // 商品をお気に入り登録する
    public function like(Request $request, Item $item)
    {
        // likesテーブル(中間テーブル)に対象ユーザーIDを追加する
        $item->likes()->detach($request->user()->id);
        $item->likes()->attach($request->user()->id);

        return [
            'id' => $item->id,
        ];
    }

    // 商品のお気に入り登録を解除する
    public function unlike(Request $request, Item $item)
    {
        // likesテーブル(中間テーブル)から対象ユーザーIDを削除する
        $item->likes()->detach($request->user()->id);

        return [
            'id' => $item->id,
        ];
    }
}

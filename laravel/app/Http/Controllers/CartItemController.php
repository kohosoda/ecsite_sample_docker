<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller
{
    // カートに入れた商品を一覧表示
    public function index()
    {
        // カート画面表示に必要なデータを取得する。cart_itemsテーブルとitemsテーブルを結合する。
        $cartItems = CartItem::select('cart_items.*', 'items.name', 'items.price')
            ->where('user_id', AUth::id())
            ->join('items', 'items.id','=','cart_items.item_id')
            ->get();

        // 小計を計算する
        $subtotal = 0;
        foreach($cartItems as $cartItem){
            $subtotal += $cartItem->price * $cartItem->quantity;
        }

        return view('cartitem.index', ['cartItems' => $cartItems, 'subtotal' => $subtotal]);
    }

    // カートに商品を追加する
    public function store(Request $request, Item $item)
    {
        // カート内のアイテムの個数を更新する。
        CartItem::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'item_id' => $request->post('item_id'),
            ],
            [
                'quantity' => DB::raw('quantity +' . $request->post('quantity') ),
            ]
        );

        return redirect()->route('item.index')->with('flash_message', 'カートに商品を追加しました');
    }

    // カート内の商品の個数を更新する
    public function update(Request $request, CartItem $cartItem)
    {
        // カート内のアイテムの個数を更新する
        $cartItem->quantity = $request->post('quantity');
        $cartItem->save();
        
        return redirect()->route('cart.index')->with('flash_message', 'カートを更新しました');
    }

    // カート内の商品を削除
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();
    
        return redirect()->route('cart.index')->with('flash_message', 'カートから削除しました');
    }        
}

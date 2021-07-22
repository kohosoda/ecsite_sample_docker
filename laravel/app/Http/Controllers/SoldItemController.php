<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\SoldItem;
use Illuminate\Http\Request;

class SoldItemController extends Controller
{
    // 商品を購入する。
    // 1.SoldItemsテーブルにレコードを追加
    // 2.CartItemsテーブルからレコードを削除
    public function store(Request $request)
    {
        // dd($request->cartItems);
        // dd(json_decode($request->cartItems));
        $cartItems = json_decode($request->cartItems); //JSON形式からオブジェクトに変換
        foreach ($cartItems as $cartItem) {
            // dd(gettype($cartItem));
            $soldItem = new SoldItem;
            $soldItem->fill((array)$cartItem)->save();

            // $soldItem->user_id = $user_id;
            // $soldItem->item_id = $cartItem->item_id;
            // $soldItem->quantity = $cartItem->quantity;
            // $soldItem->save();
        }

        // カートの中身をリセット
        $user_id = $request->user()->id;
        CartItem::where('user_id', $user_id)->delete();

        return redirect()->route('cart.index')->with('flash_message', '購入を完了しました');
    }
}

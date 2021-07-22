<?php

namespace App\Http\Controllers;

use App\Models\SoldItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // マイページを表示する
    public function show()
    {
        $user = Auth::user(); // 現在認証されているユーザーの取得

        return view('users.show', ['user' => $user]);
    }

    // 対象ユーザーの購入履歴を表示する
    public function history()
    {
        $user = Auth::user();

        // sold_itemsテーブルとitemsテーブルを結合して、ユーザーの購入履歴を取得する。
        $soldItems = SoldItem::select('sold_items.*', 'items.name', 'items.price', 'items.src')
            ->where('user_id', $user->id)
            ->join('items', 'items.id','=','sold_items.item_id')
            ->get();

        return view('users.history', ['soldItems' => $soldItems, 'user' => $user]);
    }

    // 対象ユーザーのお気に入り商品を表示する
    public function like()
    {
        $user = Auth::user();

        $items = $user->likes;

        return view('users.like', ['items' => $items, 'user' => $user]);
    }

    // ユーザー登録情報を更新する
    public function store(Request $request, User $user)
    {
        // 確認画面に進む場合、あるいは戻るボタンが押された場合
        if($request->has('confirm') || $request->has('back')){
            // 値をセッションに保存
            $request->flash();
            $user = Auth::user();
            
            return view('users.show', ['user' => $user]);
        }

        // 確認画面から更新することを決定した場合
        if($request->has('post')){
            // 値をusersテーブルに保存する
            $user = User::find(Auth::id());
            $user->fill($request->all())->save();
            
            return redirect()->route('mypage.show')->with('flash_message', '登録情報を更新しました');
        }
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use ItemsTableSeeder;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    // テスト前後のデータベースのマイグレーション＋ロールバック
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    // ユーザー登録機能の確認
    public function testUserRegister()
    {
        // ユーザー登録
        $email = 'test4@test.com';
        $this->post(route('register'), [
            'name' => 'user',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])
        ->assertStatus(302);

        // usersテーブルにデータが保存されていることを確認
        $this->assertDatabaseHas('users', ['email' => $email]);
    }

    // ログイン機能の確認
    public function testUserLogin()
    {
        // Userモデルを作成
        $user = factory(User::class)->create([
            'password' => bcrypt('password123')
        ]);

        // ログイン
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ])
        ->assertStatus(302);

        // ログイン後にマイページへアクセス
        $response = $this->get(route('mypage.show'));
        $response->assertStatus(200);
        $response = $this->actingAs($user)->get(route('mypage.like'));
        $response->assertStatus(200);
        $response = $this->actingAs($user)->get(route('mypage.history'));
        $response->assertStatus(200);
    }

    // 認証ページの動作確認
    public function testUserAuthenticate()
    {
        // 非ログイン時にマイページへアクセスした場合
        $response = $this->get(route('mypage.show'));
        $response->assertStatus(302);
        $response = $this->get(route('mypage.like'));
        $response->assertStatus(302);
        $response = $this->get(route('mypage.history'));
        $response->assertStatus(302);
    }
}

<?php

namespace Tests\Feature;
use App\Models\User;
use App\Shift;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use DatabaseMigrations;


class ShiftControllerTest extends TestCase
{
    //DBテーブルが空となり、毎回同じ条件でテストを実行できる。
    use RefreshDatabase;
    


    //ログイン無しで、user.shift.indexにルーティングするとuser.homeへ戻る。
    public function testGuestCreate()
    {
        $response = $this
        ->get(route('user.home.index'));

        $response->assertRedirect(route('user.login'));
    }

    public function testAuthCreate()
    {
        //FactoryとFakerを使って、
        $user = factory(User::class)->create();
        //（一件のレコードの持つ情報を持っている）モデルインスタンスが作成されているか
        $this->assertCount(1, User::all());
        //$userの中身である上記のモデルインスタンスを、認証に通った情報として扱える状態にして、$responseにインスタンスとして作成
        $response = $this->actingAs($user)
          ->get(route('user.home.index'));

        // $response->assertStatus(200)
        //     ->assertViewIs('articles.create');
    }

    public function testShiftIndex()
    {
        //user.home.index -> user.shift.indexへの遷移
        
        //userが認証済みであれば、user.shift.indexページが200になる。
        //ページでは、Shiftモデルがテーブルの情報を保持している。

        $user = factory(User::class)->create();
        $shift = factory(Shift::class)->create();

        $response = $this->actingAs($user)
            ->get(route('user.shifts.index'));
        
        $response->assertStatus(200)
            ->assertViewIs('user.index')
            ->assertSee('2020-11-01(日)');
        $date = $shift->where('date', '2020-11-01(日)')->first();
        // $this->assertNotNull($date);
        $this->assertTrue(
            Schema::hasColumns('shifts', [
                'id', 'date', 'start_time', 'end_time', 'rest_time', 'total', 'comments', 'monthly_id', 'work_type_id', 'user_id'
            ]),
            1
        );
    }
}

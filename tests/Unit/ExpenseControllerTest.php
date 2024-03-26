<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Expense;
use Illuminate\Support\Facades\Artisan;

class ExpenseControllerTest extends TestCase
{
    use RefreshDatabase;

    // public function setUp(){
    //     parent(setUp());
    //     Artisan::all('migrate:fresh');
    // }
    public function test_index_returns_user_expenses()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken; 
        $expense = Expense::factory()->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token, 
        ])->getJson('/api/expenses');

        $response->assertStatus(200); 
        $response->assertJsonStructure([
            '*' => [
                'description',
                'amount',
                'date',
                'user_id',
                'created_at',
                'updated_at',
                'id'
            ]
        ]);
    }

 
}

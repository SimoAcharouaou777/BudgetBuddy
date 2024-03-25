<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Expense;

class ExpenseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_user_expenses()
    {
        $user = User::factory()->create();
        $expense = Expense::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/expenses');

        $response->assertOk();
        $this->assertContains($expense->toArray(), $response->json());
    }

    // Add more tests for store, update, and destroy methods
}
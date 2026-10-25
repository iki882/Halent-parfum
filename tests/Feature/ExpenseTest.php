<?php

namespace Tests\Feature;

use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_expense_is_saved_and_included_in_expense_total(): void
    {
        $expense = Expense::create([
            'title' => 'Restock packaging',
            'amount' => '12500.50',
            'expense_date' => '2026-10-24',
            'notes' => 'Monthly packaging order',
        ]);

        $this->assertDatabaseHas('expenses', [
            'id' => $expense->id,
            'title' => 'Restock packaging',
            'amount' => '12500.50',
            'expense_date' => '2026-10-24',
            'notes' => 'Monthly packaging order',
        ]);
        $this->assertSame('12500.50', $expense->amount);
        $this->assertSame('2026-10-24', $expense->expense_date->toDateString());
        $this->assertSame(12500.5, (float) Expense::sum('amount'));
    }
}

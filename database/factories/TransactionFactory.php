<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('-50 days', 'now')->format('Y-m-d'),
            'category' => $this->faker->randomElement(array(
                "Coffee",
                "Food",
                "Petrol",
                "Drinks",
                "Activities",
                "Rent",
                "Eating out"
            )),
            'amount' => $this->faker->randomNumber(3),
            'payee' => $this->faker->randomElement(array(
                "Netflix",
                "Supermarket",
                "Cafe",
                "Resturant",
                "Movies"
            )),
            'notes' => implode(' ', array_map('ucfirst', $this->faker->words(3))),
            'account' => $this->faker->randomElement(array(
                "Everyday Spending",
                "Credit Card",
                "Food",
                "Rent"
            )),
        ];
    }
}

<?php

namespace Database\Factories;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produit>
 */
class ProduitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category_ids = DB::table('categories')->pluck('id')->toArray();
        $auteur_ids = DB::table('users')->pluck('id')->toArray();

        return [
            'title' => $this->faker->text(20),
            'description' => $this->faker->date(),
            'price' => $this->faker->text(),
            'category_id' => $this->faker->randomElement($category_ids),
            'user_id' => $this->faker->randomElement($auteur_ids),
];
    }
}

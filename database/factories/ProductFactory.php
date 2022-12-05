<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name,
            'description'=>$this->faker->paragraph,
            'price'=>$this->faker->randomElement([100,200,300,400,500]),
            'quantity'=>$this->faker->randomElement([4,5,6,3]),
            'category_id'=> Category::all()->random()->id,
            'img1'=>'https://source.unsplash.com/random',
            'img2'=>'https://source.unsplash.com/random',
            'img3'=>'https://source.unsplash.com/random',
        ];
    }
}

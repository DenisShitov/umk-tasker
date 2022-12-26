<?php

namespace Database\Factories;

use App\Models\Status;
use Facades\Admin\Static\Color;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            // 'status_id' => $this->faker->randomElement([3, 4]),
            // 'color_id' => $this->faker->randomElement([13, 26]),
            // 'status_id' => Status::factory(),
            // 'color_id' => Color::factory(),
            // 'started_at' => $this->faker->dateTime(),
            // 'due_at' => $this->faker->dateTime(),
            // 'archived_at' => $this->faker->dateTime(),
            'description' => $this->faker->text,
            'meta' => [
                'color' => Color::default(),
            ],
        ];
    }
}

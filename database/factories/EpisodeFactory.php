<?php

namespace Database\Factories;

use App\Models\Episode;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Episode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraphs(3,true),
            'course_id' => Course::all()->random()->id,
            'video_url' => 'https://www.youtube.com/watch?v=Kudd571cvRY&t=162s'
        ];
    }
}

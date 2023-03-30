<?php

namespace Database\Factories;

use App\Models\Domain;
use Illuminate\Database\Eloquent\Factories\Factory;

class DomainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Domain::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account' => $this->faker->username,
            'name' => $this->faker->domainName,
            'usage' => $this->faker->randomFloat(2, 0, 100),
            'backup' => $this->faker->boolean,
            'renew' => $this->faker->boolean,
            'enable' => $this->faker->boolean,
            'remark' => $this->faker->word,
            'registered_at' => $this->faker->dateTime('Asia/Taipei'),
            'expired_at' => $this->faker->dateTime('Asia/Taipei'),
        ];
    }
}

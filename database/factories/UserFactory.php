<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role_id' => User::NORMAL_USER,
            'google_id' => null,
            'email' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->userName,
            'password' => Hash::make(User::PASSWORD_DEFAULT),
            'name' => $this->faker->name,
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'middlename' => $this->faker->firstNameMale,
            'nick_name' => $this->faker->userName,
            'avatar' => url('/') . '/images/user-logo.png',
            'birth_date' => $this->faker->dateTimeThisCentury()->format('Y-m-d'),
            'gender' => User::FEMALE,
            'zip_code' => $this->faker->postcode('US'),
            'address' => $this->faker->address,
            'tel' => $this->faker->phoneNumber,
            'remember_token' => null,
            'email_verified_at' => null
        ];
    }
}
?>
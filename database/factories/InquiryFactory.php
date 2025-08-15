<?php

namespace Database\Factories;

use App\InquiryStatus;
use App\Services\TicketIDGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inquiry>
 */
class InquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_id' => TicketIDGenerator::generate(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'subject' => $this->faker->sentence(),
            'email' => $this->faker->email(),
            'message' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(InquiryStatus::cases())->value,
        ];
    }
}

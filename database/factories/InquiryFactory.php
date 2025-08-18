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
            'ticket_id' => $this->generateUniqueTicketId(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'subject' => $this->faker->sentence(),
            'email' => $this->faker->email(),
            'message' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(InquiryStatus::cases()),
        ];
    }

    private function generateUniqueTicketId(): string
    {
        // In testing environment or when running tests, generate unique ticket IDs to avoid conflicts
        if (app()->environment('testing') || app()->runningUnitTests()) {
            // Use microtime and random number for uniqueness
            $timestamp = (int) (microtime(true) * 10000);
            $random = mt_rand(1000, 9999);
            $unique = $timestamp + $random;
            
            return "TK-TEST-{$unique}";
        }

        // In production, use the real generator
        return TicketIDGenerator::generate();
    }
}

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
        // In testing, generate unique ticket IDs to avoid conflicts
        if (app()->environment('testing')) {
            static $counter = 0;
            $counter++;
            $month = strtoupper(date('M'));
            $day = date('d');

            return "AK-{$month}{$day}-".str_pad((string) $counter, 4, '0', STR_PAD_LEFT);
        }

        // In production, use the real generator
        return TicketIDGenerator::generate();
    }
}

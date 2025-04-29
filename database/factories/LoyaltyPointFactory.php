<?php

namespace Database\Factories;

use App\Models\LoyaltyPoint;
use App\Models\User;
use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoyaltyPointFactory extends Factory
{
    protected $model = LoyaltyPoint::class;

    public function definition()
    {
        $sources = ['service_completion', 'review', 'referral', 'promotion'];
        
        return [
            'professional_id' => User::where('role', 'professional')->inRandomOrder()->first()->id ?? User::factory()->create(['role' => 'professional']),
            'points_earned' => $this->faker->numberBetween(1, 25),
            'source' => $this->faker->randomElement($sources),
            'service_request_id' => function () {
                return rand(0, 1) ? ServiceRequest::inRandomOrder()->first()->id : null;
            },
            'description' => $this->faker->sentence(),
        ];
    }
    
    public function forServiceCompletion(ServiceRequest $serviceRequest)
    {
        return $this->state(function () use ($serviceRequest) {
            return [
                'professional_id' => $serviceRequest->professional_id,
                'points_earned' => 5, 
                'source' => 'service_completion',
                'service_request_id' => $serviceRequest->id,
                'description' => 'Points earned for completing service',
            ];
        });
    }
    
    public function forReview(ServiceRequest $serviceRequest, int $rating)
    {
        return $this->state(function () use ($serviceRequest, $rating) {
            return [
                'professional_id' => $serviceRequest->professional_id,
                'points_earned' => $rating, 
                'source' => 'review',
                'service_request_id' => $serviceRequest->id,
                'description' => 'Points earned from client review',
            ];
        });
    }
} 
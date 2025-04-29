<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        $serviceRequest = ServiceRequest::where('status', 'completed')
            ->inRandomOrder()
            ->first();
            
        if (!$serviceRequest) {
            $serviceRequest = ServiceRequest::factory()->completed()->create();
        }
        
        return [
            'client_id' => $serviceRequest->client_id,
            'professional_id' => $serviceRequest->professional_id,
            'service_request_id' => $serviceRequest->id,
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->paragraph(),
            'is_approved' => $this->faker->boolean(90), 
        ];
    }
    
    public function highRating()
    {
        return $this->state(function () {
            return [
                'rating' => $this->faker->numberBetween(4, 5),
                'comment' => $this->faker->randomElement([
                    'Excellent service! Highly recommended.',
                    'Very professional and efficient. Would hire again.',
                    'Amazing work quality and fast completion.',
                    'Exceptional service, exceeded my expectations.',
                    'Great attention to detail and very punctual.'
                ]),
            ];
        });
    }

    public function lowRating()
    {
        return $this->state(function () {
            return [
                'rating' => $this->faker->numberBetween(1, 2),
                'comment' => $this->faker->randomElement([
                    'Not satisfied with the work done.',
                    'Service was below expectations.',
                    'Too expensive for the quality provided.',
                    'Delayed completion and poor communication.',
                    'Would not recommend or use again.'
                ]),
            ];
        });
    }
} 
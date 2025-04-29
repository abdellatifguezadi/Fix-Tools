<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\ServiceRequest;

class ReviewSeeder extends Seeder
{

    public function run(): void
    {
        $completedServiceRequests = ServiceRequest::where('status', 'completed')->get();
        
        foreach ($completedServiceRequests as $serviceRequest) {
            $existingReview = Review::where('service_request_id', $serviceRequest->id)->first();
            
            if (!$existingReview) {
                if (rand(1, 10) <= 7) {
                    if (rand(1, 10) <= 8) {
                        Review::factory()->highRating()->create([
                            'client_id' => $serviceRequest->client_id,
                            'professional_id' => $serviceRequest->professional_id,
                            'service_request_id' => $serviceRequest->id,
                        ]);
                    } else {
                        Review::factory()->create([
                            'client_id' => $serviceRequest->client_id,
                            'professional_id' => $serviceRequest->professional_id,
                            'service_request_id' => $serviceRequest->id,
                        ]);
                    }
                }
            }
        }
        
        $reviewCount = Review::count();
        if ($reviewCount < 10) {
            Review::factory()->count(10 - $reviewCount)->create();
        }
    }
} 
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LoyaltyPoint;
use App\Models\ServiceRequest;
use App\Models\Review;
use App\Models\User;

class LoyaltyPointSeeder extends Seeder
{
   
    public function run(): void
    {
        $completedServiceRequests = ServiceRequest::where('status', 'completed')->get();
        
        foreach ($completedServiceRequests as $serviceRequest) {
            $existingPoints = LoyaltyPoint::where('service_request_id', $serviceRequest->id)
                                         ->where('source', 'service_completion')
                                         ->first();
            
            if (!$existingPoints && $serviceRequest->professional_id) {
                LoyaltyPoint::create([
                    'professional_id' => $serviceRequest->professional_id,
                    'points_earned' => 5, 
                    'source' => 'service_completion',
                    'service_request_id' => $serviceRequest->id,
                    'description' => 'Points earned for completing service #' . $serviceRequest->id,
                ]);

                $review = Review::where('service_request_id', $serviceRequest->id)->first();
                
                if ($review) {
                    $existingReviewPoints = LoyaltyPoint::where('service_request_id', $serviceRequest->id)
                                                       ->where('source', 'review')
                                                       ->first();
                    
                    if (!$existingReviewPoints) {
                        LoyaltyPoint::create([
                            'professional_id' => $serviceRequest->professional_id,
                            'points_earned' => $review->rating, 
                            'source' => 'review',
                            'service_request_id' => $serviceRequest->id,
                            'description' => 'Points earned from ' . $review->rating . '-star review for service #' . $serviceRequest->id,
                        ]);
                    }
                }
            }
        }
        
        $professionals = User::where('role', 'professional')->get();
        
        foreach ($professionals as $professional) {
            $promoCount = rand(1, 3);
            
            for ($i = 0; $i < $promoCount; $i++) {
                LoyaltyPoint::create([
                    'professional_id' => $professional->id,
                    'points_earned' => rand(5, 20),
                    'source' => 'promotion',
                    'service_request_id' => null,
                    'description' => 'Promotional points: ' . $this->getRandomPromotion(),
                ]);
            }
        }
    }
    

    private function getRandomPromotion(): string
    {
        $promotions = [
            'Welcome bonus',
            'Monthly professional bonus',
            'Seasonal promotion',
            'Service anniversary reward',
            'Professional engagement reward',
            'Platform participation bonus',
        ];
        
        return $promotions[array_rand($promotions)];
    }
} 
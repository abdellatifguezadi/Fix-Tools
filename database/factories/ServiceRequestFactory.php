<?php

namespace Database\Factories;

use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceRequestFactory extends Factory
{
    protected $model = ServiceRequest::class;

    public function definition()
    {
       
        $client = User::where('role', 'client')->inRandomOrder()->first();
        $professional = User::where('role', 'professional')->inRandomOrder()->first();
        

        $service = Service::where('professional_id', $professional->id)->inRandomOrder()->first();
        
        if (!$service) {

            $service = Service::inRandomOrder()->first();
        }
        
        $statuses = ['pending', 'priced', 'accepted', 'completed', 'cancelled'];
        $status = $this->faker->randomElement($statuses);
        

        $requestedDate = $this->faker->dateTimeBetween('-3 months', '-1 day');
        $completedDate = null;
        
        if ($status === 'completed') {
            $maxDate = min(new \DateTime('now'), (clone $requestedDate)->modify('+2 weeks'));
            $completedDate = $this->faker->dateTimeBetween($requestedDate, $maxDate);
        }
        
        $finalPrice = null;
        if (in_array($status, ['priced', 'accepted', 'completed'])) {
            $finalPrice = $this->faker->randomFloat(2, 50, 1000);
        }
        
        return [
            'service_id' => $service->id,
            'client_id' => $client->id,
            'professional_id' => $professional->id,
            'description' => $this->faker->paragraph(),
            'final_price' => $finalPrice,
            'status' => $status,
            'requested_date' => $requestedDate,
            'completed_date' => $completedDate,
        ];
    }
    
    public function completed()
    {
        return $this->state(function (array $attributes) {
            $requestedDate = $this->faker->dateTimeBetween('-3 months', '-15 days');
            $completedDate = $this->faker->dateTimeBetween($requestedDate, '-1 day');
            
            return [
                'status' => 'completed',
                'completed_date' => $completedDate,
                'final_price' => $this->faker->randomFloat(2, 50, 1000),
                'requested_date' => $requestedDate,
            ];
        });
    }
} 
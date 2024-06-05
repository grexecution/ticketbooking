<?php

namespace Database\Seeders;

use App\Models\SeatPlan\SeatPlan;
use App\Models\SeatPlan\SeatPlanCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeatPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSeatPlans = [
            [
                'id' => 1,
                'name' => 'Custom',
                'description' => 'Custom plan to No Seat Selection events',
                'places' => 160,
                'is_custom' => true,
                'categories' => [
                    [
                        'name' => 'Category A',
                        'description' => '',
                        'price' => 20.00,
                        'places' => 30,
                        'rows' => 0,
                        'seats' => 0,
                    ],
                    [
                        'name' => 'Category B',
                        'description' => '',
                        'price' => 20.00,
                        'places' => 30,
                        'rows' => 0,
                        'seats' => 0,
                    ],
                    [
                        'name' => 'Category C',
                        'description' => '',
                        'price' => 20.00,
                        'places' => 30,
                        'rows' => 0,
                        'seats' => 0,
                    ],
                    [
                        'name' => 'Category D',
                        'description' => '',
                        'price' => 20.00,
                        'places' => 30,
                        'rows' => 0,
                        'seats' => 0,
                    ],
                ]
            ],
            [
                'id' => 2,
                'name' => 'Orpheum Vienna Small',
                'description' => 'Orpheum Vienna Small (150 seats)',
                'places' => 180,
                'is_custom' => false,
                'categories' => [
                    [
                        'name' => 'Category A',
                        'description' => '',
                        'price' => 20.00,
                        'places' => 45,
                        'rows' => 3,
                        'seats' => 15,
                    ],
                    [
                        'name' => 'Category B',
                        'description' => '',
                        'price' => 20.00,
                        'places' => 45,
                        'rows' => 3,
                        'seats' => 15,
                    ],
                    [
                        'name' => 'Category C',
                        'description' => '',
                        'price' => 20.00,
                        'places' => 45,
                        'rows' => 3,
                        'seats' => 15,
                    ],
                    [
                        'name' => 'Category D',
                        'description' => '',
                        'price' => 20.00,
                        'places' => 45,
                        'rows' => 3,
                        'seats' => 15,
                    ],
                ]
            ],
            [
                'id' => 3,
                'name' => 'Orpheum Vienna Medium',
                'description' => 'Orpheum Vienna Medium (320 seats)',
                'places' => 320,
                'is_custom' => false,
                'categories' => [
                    [
                        'name' => 'VIP',
                        'description' => '',
                        'price' => 50.00,
                        'places' => 20,
                        'rows' => 6,
                        'seats' => 20,
                    ],
                    [
                        'name' => 'Category A',
                        'description' => '',
                        'price' => 40.00,
                        'places' => 30,
                        'rows' => 6,
                        'seats' => 20,
                    ],
                    [
                        'name' => 'Category B',
                        'description' => '',
                        'price' => 40.00,
                        'places' => 30,
                        'rows' => 6,
                        'seats' => 20,
                    ],
                    [
                        'name' => 'Category C',
                        'description' => '',
                        'price' => 40.00,
                        'places' => 30,
                        'rows' => 6,
                        'seats' => 20,
                    ],
                ]
            ],
        ];

        foreach ($defaultSeatPlans as $defaultSeatPlan) {
            $categories = $defaultSeatPlan['categories'];
            $query = SeatPlan::query()->where('id', $defaultSeatPlan['id']);

            if ($query->exists()) {
                $seatPlan = $query->first();
            } else {
                unset($defaultSeatPlan['categories']);
                $seatPlan = SeatPlan::create($defaultSeatPlan);
            }

            foreach ($categories as $category) {
                if (SeatPlanCategory::query()
                    ->where('seat_plan_id', $seatPlan->id)
                    ->where('name', $category['name'])
                    ->exists()) {
                    continue;
                }
                $category['seat_plan_id'] = $seatPlan->id;
                SeatPlanCategory::query()->create($category);
            }
        }
    }
}

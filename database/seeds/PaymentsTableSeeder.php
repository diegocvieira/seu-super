<?php

use Illuminate\Database\Seeder;
use App\Models\Payment;
use Illuminate\Support\Str;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments = [
            0 => [
                'name' => 'MasterCard',
                'type' => 2
            ],
            1 => [
                'name' => 'Visa',
                'type' => 2
            ],
            2 => [
                'name' => 'Cabal',
                'type' => 2
            ],
            3 => [
                'name' => 'Hipercard',
                'type' => 2
            ],
            4 => [
                'name' => 'Dinners Club',
                'type' => 2
            ],
            5 => [
                'name' => 'American Express',
                'type' => 2
            ],
            6 => [
                'name' => 'MasterCard',
                'type' => 3
            ],
            7 => [
                'name' => 'Visa',
                'type' => 3
            ],
            8 => [
                'name' => 'Cabal',
                'type' => 3
            ],
            9 => [
                'name' => 'Hipercard',
                'type' => 3
            ],
            10 => [
                'name' => 'Dinners Club',
                'type' => 3
            ],
            11 => [
                'name' => 'American Express',
                'type' => 3
            ],
            12 => [
                'name' => 'Dinheiro',
                'type' => 1
            ]
        ];

        foreach ($payments as $payment) {
            Payment::create([
                'name' => $payment['name'],
                'slug' => Str::slug($payment['name'], '-'),
                'type' => $payment['type']
            ]);
        }
    }
}

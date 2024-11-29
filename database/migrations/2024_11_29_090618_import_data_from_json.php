<?php

use App\Models\Mask;
use App\Models\Pharmacy;
use App\Models\PurchaseHistory;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $pharmaciesPath = storage_path('data/pharmacies.json');
        $usersPath = storage_path('data/users.json');
        if (!file_exists($pharmaciesPath)) {
            throw new Exception("JSON file not found: $pharmaciesPath");
        }
        if (!file_exists($usersPath)) {
            throw new Exception("JSON file not found: $usersPath");
        }
        $pharmacies = json_decode(file_get_contents($pharmaciesPath), true);
        $users = json_decode(file_get_contents($usersPath), true);
        if (!is_array($pharmacies)) {
            throw new Exception("Invalid JSON structure in $pharmaciesPath");
        }
        if (!is_array($users)) {
            throw new Exception("Invalid JSON structure in $usersPath");
        }
        Log::info(["pharmacies" => $pharmacies]);
        Log::info(["users" => $users]);
        foreach ($pharmacies as $key => $pharmacy) {
            $pharmacyData = Pharmacy::create([
                'name' => $pharmacy['name'],
                'cash_balance' => $pharmacy['cashBalance'],
                'opening_hours' => $pharmacy['openingHours'],
            ]);
            foreach ($pharmacy['masks'] as $key => $mask) {
                Mask::create([
                    'pharmacy_id' => $pharmacyData->id,
                    'name' => $mask['name'],
                    'price' => $mask['price'],
                ]);
            }
        }
        foreach ($users as $key => $user) {
            $userData = User::create([
                'name' => $user['name'],
                'cash_balance' => $user['cashBalance'],
            ]);
            foreach ($user['purchaseHistories'] as $key => $history) {
                $pharmacyData = Pharmacy::whereName($history['pharmacyName'])->first();
                $masksData = $pharmacyData->masks()->SearchName($history['maskName'])->first();
                PurchaseHistory::create([
                    'user_id' => $userData->id,
                    'pharmacy_id' => $pharmacyData->id,
                    'mask_id' => $masksData->id,
                    'pharmacy_name' => $pharmacyData->name,
                    'mask_name' => $masksData->name,
                    'transaction_amount' => $history['transactionAmount'],
                    'transaction_date' => $history['transactionDate'],
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('json', function (Blueprint $table) {
            //
        });
    }
};

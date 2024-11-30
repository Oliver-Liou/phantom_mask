<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\Mask;
use App\Models\Pharmacy;
use App\Models\PurchaseHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::SearchTransactionRank($request->get('transaction_rank'), [$request->get('transaction_start'), $request->get('transaction_end')])
            ->get();

        return response()->json(['result' => 'success', 'users' => new UserCollection($users)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Process a user purchases a mask from a pharmacy, and handle all relevant data changes in an atomic transaction.
     */
    public function purchase(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'pharmacy_id' => 'required',
            'mask_id' => 'required',
        ];

        $messages = [
            'user_id.required' => 'User id is required！',
            'pharmacy_id.required' => 'Pharmacy id is required！',
            'mask_id.required' => 'Mask id is required！',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $message = (is_array($validator->errors()))? $validator->errors()->all()[0]:'Please input data！';
            return response()->json(['result' => 'failed', 'message' => $message]);
        }

        DB::beginTransaction();
        try {
            $user = User::lockForUpdate()->find($request->get('user_id'));
            $pharmacy = Pharmacy::lockForUpdate()->find($request->get('pharmacy_id'));
            $mask = Mask::lockForUpdate()->find($request->get('mask_id'));
            if (empty($user)) {
                DB::rollBack();
                return response()->json(['result' => 'failed', 'message' => 'User not found！']);
            }
            if (empty($pharmacy)) {
                DB::rollBack();
                return response()->json(['result' => 'failed', 'message' => 'Pharmacy not found！']);
            }
            if (empty($mask)) {
                DB::rollBack();
                return response()->json(['result' => 'failed', 'message' => 'Mask not found！']);
            }

            $user->cash_balance -= $mask->price;
            $user->save();
            $pharmacy->cash_balance += $mask->price;
            $pharmacy->save();
            // Check user cash balance.
            if ($user->cash_balance < 0) {
                DB::rollBack();
                return response()->json(['result' => 'failed', 'message' => 'User cash balance not enough！']);
            }
            // Create purchase history
            PurchaseHistory::create([
                'user_id' => $user->id,
                'pharmacy_id' => $pharmacy->id,
                'mask_id' => $mask->id,
                'pharmacy_name' => $pharmacy->name,
                'mask_name' => $mask->name,
                'transaction_amount' => $mask->price,
                'transaction_date' => now(),
            ]);
            DB::commit();
            return response()->json(['result' => 'success', 'message' => 'purchase completed！']);
        }catch (\Exception $e) {
            Log::error('purchase error:'. $e->getMessage());
            DB::rollBack();
            return response()->json(['result' => 'failed', 'message' => $e->getMessage()]);
        }
    }
}

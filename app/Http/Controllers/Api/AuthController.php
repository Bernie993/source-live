<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * External user login via API verification
     */
    public function externalLogin(Request $request)
    {
        $validated = $request->validate([
            'account' => 'required|string',
            'bank_account' => 'required|string',
            'platform' => 'string|default:u888'
        ]);

        try {
            // Call external API to verify user
            $response = Http::withHeaders([
                'X-Api-Key' => 'saghrt3Pnzxcfgy',
                'User-Agent' => 'Apifox/1.0.0 (https://apifox.com)',
                'Content-Type' => 'application/json'
            ])->post('http://13.215.85.106:8080/api/v1/gifts/eligibility', [
                'platform' => $validated['platform'] ?? 'u888',
                'account' => $validated['account'],
                'bank_account' => $validated['bank_account'],
                'start_time' => now()->subDays(30)->format('Y-m-d H:i:s'),
                'end_time' => now()->format('Y-m-d H:i:s')
            ]);

            if ($response->successful() && $response->json()) {
                $apiData = $response->json();
                
                // Check if user already exists
                $user = User::where('account', $validated['account'])
                    ->where('bank_account', $validated['bank_account'])
                    ->where('user_type', 'external_login')
                    ->first();

                if (!$user) {
                    // Create new user
                    $user = User::create([
                        'name' => $validated['account'],
                        'email' => null, // No email for external login
                        'password' => Hash::make(Str::random(32)),
                        'account' => $validated['account'],
                        'bank_account' => $validated['bank_account'],
                        'platform' => $validated['platform'] ?? 'u888',
                        'user_type' => 'external_login',
                        'api_response' => $apiData
                    ]);
                } else {
                    // Update existing user's API response
                    $user->update([
                        'api_response' => $apiData
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Đăng nhập thành công',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'account' => $user->account,
                        'bank_account' => $user->bank_account,
                        'platform' => $user->platform
                    ],
                    'api_data' => $apiData
                ]);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Thông tin không hợp lệ hoặc không tìm thấy dữ liệu'
                ], 401);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi kết nối API: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user profile
     */
    public function profile(Request $request)
    {
        $user = User::where('account', $request->account)
            ->where('bank_account', $request->bank_account)
            ->where('user_type', 'external_login')
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Người dùng không tồn tại'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'account' => $user->account,
                'bank_account' => $user->bank_account,
                'platform' => $user->platform,
                'created_at' => $user->created_at
            ]
        ]);
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EligibilityService
{
    private $apiUrl = 'http://13.215.85.106:8080/api/v1/gifts/eligibility';
    private $apiKey = 'saghrt3Pnzxcfgy';
    private $platform = 'u888';
    private $testMode = false; // Set to true for testing

    public function __construct()
    {
        // Disable test mode to use real API - set to true to enable test mode
        $this->testMode = false;
    }

    /**
     * Check user eligibility through external API
     *
     * @param string $account
     * @param string $bankAccount
     * @return array
     */
    public function checkEligibility(string $account, string $bankAccount): array
    {
        // Test mode for development
        if ($this->testMode) {
            Log::info('Eligibility API Call (Test Mode)', [
                'account' => $account,
                'bank_account' => $bankAccount,
            ]);

            // Simulate successful response for testing
            return [
                'success' => true,
                'data' => [
                    'eligible' => true,
                    'account' => $account,
                    'bank_account' => $bankAccount,
                    'test_mode' => true
                ],
                'message' => 'Tài khoản hợp lệ (Test Mode)'
            ];
        }

        try {
            // Calculate time range (current time to 5 days later)
            $startTime = now()->format('Y-m-d H:i:s');
            $endTime = now()->addDays(5)->format('Y-m-d H:i:s');

            $response = Http::timeout(30) // Add timeout
                ->withHeaders([
                    'X-Api-Key' => $this->apiKey,
                    'User-Agent' => 'Apifox/1.0.0 (https://apifox.com)',
                    'Content-Type' => 'application/json',
                ])->post($this->apiUrl, [
                    'platform' => $this->platform,
                    'account' => $account,
                    'bank_account' => $bankAccount,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                ]);

            // Log the API call for debugging
            Log::info('Eligibility API Call', [
                'account' => $account,
                'bank_account' => $bankAccount,
                'status_code' => $response->status(),
                'response_body' => $response->body(),
                'url' => $this->apiUrl,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // IMPORTANT: API always returns HTTP 200, but uses 'Code' field to indicate success/failure
                // Code 200 = Success
                // Code 20002 = Member account not found
                // Code 10001 = Invalid request format
                $responseCode = $data['Code'] ?? null;
                $responseError = $data['Error'] ?? null;
                
                if ($responseCode === 200) {
                    // Valid account - has Result data
                    return [
                        'success' => true,
                        'data' => $data,
                        'message' => 'Tài khoản hợp lệ'
                    ];
                } else {
                    // Invalid account or error - Simple message
                    $errorMessage = 'Thông tin tài khoản không đúng';
                    
                    Log::warning('Eligibility API returned error code', [
                        'account' => $account,
                        'bank_account' => $bankAccount,
                        'response_code' => $responseCode,
                        'error' => $responseError,
                    ]);
                    
                    return [
                        'success' => false,
                        'message' => $errorMessage,
                        'error_code' => $responseCode
                    ];
                }
            } else {
                Log::warning('Eligibility API HTTP request failed', [
                    'status_code' => $response->status(),
                    'response_body' => $response->body(),
                ]);
                
                return [
                    'success' => false,
                    'message' => 'Không thể kết nối đến máy chủ xác thực',
                    'error_code' => $response->status()
                ];
            }

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Eligibility API Connection Error', [
                'account' => $account,
                'bank_account' => $bankAccount,
                'error' => $e->getMessage(),
                'url' => $this->apiUrl,
            ]);

            return [
                'success' => false,
                'message' => 'Không thể kết nối đến máy chủ xác thực',
                'error' => 'Connection timeout or refused'
            ];

        } catch (\Exception $e) {
            Log::error('Eligibility API Error', [
                'account' => $account,
                'bank_account' => $bankAccount,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra khi kiểm tra tài khoản',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Format API response for storage
     *
     * @param array $apiResponse
     * @return array
     */
    public function formatApiResponse(array $apiResponse): array
    {
        return [
            'api_call_time' => now(),
            'response_data' => $apiResponse,
            'platform' => $this->platform,
        ];
    }
}

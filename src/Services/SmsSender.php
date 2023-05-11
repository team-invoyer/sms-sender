<?php

namespace Invoyer\SmsSender\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class SmsSender
{
    private string $baseUrl;
    private string $login;
    private string $apiKey;
    private string $sender;

    /**
     * @param string $phone - number you sending SMS to
     * @param string $text - your text message (SMS) content
     */
    public function __construct(
        public string $phone,
        public string $text
    )
    {
        $this->baseUrl = config('onesoft.tcg.base_url');
        $this->login = config('onesoft.tcg.login');
        $this->apiKey = config('onesoft.tcg.api_key');
        $this->sender = config('onesoft.tcg.sender');
    }

    public function send()
    {
        try {
            $params = $this->getRequestParams();

            $response = [
                'callback' => Http::get($this->generateSendingLink($params))->json(),
                'params' => $params,
            ];

            Log::info('Send SMS', [
                'to' => $this->phone,
                'text' => $this->text,
                'response' => $response
            ]);

            return $response['callback'];
        } catch (Exception) {
            Log::info('SMS FAILED', [
                'to' => $this->phone,
                'text' => $this->text,
                'response' => $response['callback'] ?? '-'
            ]);

            return [];
        }
    }

    private function signature(array $params, string $apiKey): string
    {
        ksort($params);
        reset($params);

        return md5(implode($params) . $apiKey);
    }

    private function generateSendingLink(array $params): string
    {
        return $this->baseUrl . 'send.php?' . http_build_query($params);
    }

    private function getRequestParams(): array
    {
        $params = [
            'timestamp' => Carbon::now()->timestamp,
            'login' => $this->login,
            'sender' => $this->sender,
            'phone' => $this->phone,
            'text' => $this->text,
            'return' => 'json'
        ];

        $params['signature'] = $this->signature($params, $this->apiKey);

        return $params;
    }
}
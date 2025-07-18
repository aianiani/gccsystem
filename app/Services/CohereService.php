<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CohereService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.cohere.ai/v1/';

    public function __construct()
    {
        $this->apiKey = config('services.cohere.api_key');
    }

    public function sentiment($text)
    {
        // Use Cohere's classify endpoint with your own examples
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . 'classify', [
            'model' => 'large',
            'inputs' => [$text],
            'examples' => [
                ['text' => 'I am happy', 'label' => 'positive'],
                ['text' => 'I am sad', 'label' => 'negative'],
                ['text' => 'I am okay', 'label' => 'neutral'],
                ['text' => 'I feel terrible', 'label' => 'negative'],
                ['text' => 'This is great', 'label' => 'positive'],
                ['text' => 'I am worried', 'label' => 'negative'],
                ['text' => 'I am fine', 'label' => 'neutral'],
            ],
        ]);

        if ($response->successful()) {
            return $response->json('classifications.0.prediction');
        }
        return null;
    }

    // You can add more methods for key phrases, summarization, etc.
} 
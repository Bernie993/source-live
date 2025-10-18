<?php

namespace App\Services;

use App\Models\Keyword;

class KeywordFilterService
{
    /**
     * Filter message against blocked keywords
     *
     * @param string $message
     * @param bool $checkLinks Check for links (URLs)
     * @return array
     */
    public function filterMessage(string $message, bool $checkLinks = false): array
    {
        $blockedKeywords = [];
        
        // Check for links if enabled
        if ($checkLinks && $this->containsLink($message)) {
            return [
                'is_blocked' => true,
                'blocked_keywords' => ['link/URL'],
                'reason' => 'contains_link'
            ];
        }
        
        $activeKeywords = Keyword::active()->pluck('keyword')->toArray();
        
        if (empty($activeKeywords)) {
            return [
                'is_blocked' => false,
                'blocked_keywords' => [],
                'reason' => null
            ];
        }

        $messageWords = $this->extractWords($message);
        
        foreach ($activeKeywords as $keyword) {
            if ($this->containsKeyword($message, $keyword)) {
                $blockedKeywords[] = $keyword;
            }
        }

        return [
            'is_blocked' => !empty($blockedKeywords),
            'blocked_keywords' => $blockedKeywords,
            'reason' => !empty($blockedKeywords) ? 'contains_keyword' : null
        ];
    }

    /**
     * Check if message contains a link/URL
     *
     * @param string $message
     * @return bool
     */
    private function containsLink(string $message): bool
    {
        // Pattern to detect URLs (http, https, www, or domain.com patterns)
        $patterns = [
            '/https?:\/\//i',                                    // http:// or https://
            '/www\./i',                                          // www.
            '/[a-zA-Z0-9-]+\.(com|net|org|vn|info|biz|co)/i'    // domain.com, domain.net, etc.
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if message contains a specific keyword
     *
     * @param string $message
     * @param string $keyword
     * @return bool
     */
    private function containsKeyword(string $message, string $keyword): bool
    {
        // Convert to lowercase for case-insensitive matching
        $message = strtolower($message);
        $keyword = strtolower($keyword);

        // Check for exact word match (not just substring)
        $pattern = '/\b' . preg_quote($keyword, '/') . '\b/u';
        
        return preg_match($pattern, $message) === 1;
    }

    /**
     * Extract words from message
     *
     * @param string $message
     * @return array
     */
    private function extractWords(string $message): array
    {
        // Remove special characters and split by spaces
        $cleanMessage = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $message);
        $words = preg_split('/\s+/', trim($cleanMessage));
        
        return array_filter($words, function($word) {
            return !empty(trim($word));
        });
    }

    /**
     * Get keyword statistics
     *
     * @return array
     */
    public function getKeywordStats(): array
    {
        return [
            'total_keywords' => Keyword::count(),
            'active_keywords' => Keyword::active()->count(),
            'inactive_keywords' => Keyword::where('is_active', false)->count(),
        ];
    }

    /**
     * Clean message by removing blocked keywords
     *
     * @param string $message
     * @param string $replacement
     * @return string
     */
    public function cleanMessage(string $message, string $replacement = '***'): string
    {
        $activeKeywords = Keyword::active()->pluck('keyword')->toArray();
        
        if (empty($activeKeywords)) {
            return $message;
        }

        $cleanMessage = $message;
        
        foreach ($activeKeywords as $keyword) {
            $pattern = '/\b' . preg_quote($keyword, '/') . '\b/iu';
            $cleanMessage = preg_replace($pattern, $replacement, $cleanMessage);
        }

        return $cleanMessage;
    }
}

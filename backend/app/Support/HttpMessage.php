<?php

namespace App\Support;

/**
 * HttpMessage
 *
 * Pesan default untuk HTTP Status Code.
 * Bisa dioverride di controller jika perlu.
 */
class HttpMessage
{
    public static function fromStatus(int $status): string
    {
        return match ($status) {

            // 1xx
            HttpStatus::CONTINUE => 'Continue',
            HttpStatus::SWITCHING_PROTOCOLS => 'Switching protocols',
            HttpStatus::PROCESSING => 'Processing',

            // 2xx
            HttpStatus::OK => 'Success',
            HttpStatus::CREATED => 'Resource created successfully',
            HttpStatus::ACCEPTED => 'Request accepted',
            HttpStatus::NON_AUTHORITATIVE_INFORMATION => 'Non-authoritative information',
            HttpStatus::NO_CONTENT => 'No content',
            HttpStatus::RESET_CONTENT => 'Reset content',
            HttpStatus::PARTIAL_CONTENT => 'Partial content',

            // 3xx
            HttpStatus::MULTIPLE_CHOICES => 'Multiple choices',
            HttpStatus::MOVED_PERMANENTLY => 'Resource moved permanently',
            HttpStatus::FOUND => 'Resource found',
            HttpStatus::SEE_OTHER => 'See other resource',
            HttpStatus::NOT_MODIFIED => 'Not modified',
            HttpStatus::TEMPORARY_REDIRECT => 'Temporary redirect',
            HttpStatus::PERMANENT_REDIRECT => 'Permanent redirect',

            // 4xx
            HttpStatus::BAD_REQUEST => 'Bad request',
            HttpStatus::UNAUTHORIZED => 'Unauthorized',
            HttpStatus::PAYMENT_REQUIRED => 'Payment required',
            HttpStatus::FORBIDDEN => 'Forbidden',
            HttpStatus::NOT_FOUND => 'Resource not found',
            HttpStatus::METHOD_NOT_ALLOWED => 'Method not allowed',
            HttpStatus::NOT_ACCEPTABLE => 'Not acceptable',
            HttpStatus::REQUEST_TIMEOUT => 'Request timeout',
            HttpStatus::CONFLICT => 'Conflict occurred',
            HttpStatus::GONE => 'Resource no longer available',
            HttpStatus::PAYLOAD_TOO_LARGE => 'Payload too large',
            HttpStatus::UNSUPPORTED_MEDIA_TYPE => 'Unsupported media type',
            HttpStatus::UNPROCESSABLE_ENTITY => 'Validation failed',
            HttpStatus::TOO_MANY_REQUESTS => 'Too many requests',

            // 5xx
            HttpStatus::INTERNAL_SERVER_ERROR => 'Internal server error',
            HttpStatus::NOT_IMPLEMENTED => 'Not implemented',
            HttpStatus::BAD_GATEWAY => 'Bad gateway',
            HttpStatus::SERVICE_UNAVAILABLE => 'Service unavailable',
            HttpStatus::GATEWAY_TIMEOUT => 'Gateway timeout',

            default => 'Unknown status',
        };
    }
}

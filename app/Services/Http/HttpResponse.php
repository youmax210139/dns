<?php
namespace App\Services\Http;

use GuzzleHttp\Psr7\Response;

class HttpResponse extends Response
{
    protected $url;
    protected $message;

    public function __construct(
        $status = 200,
        $message = null,
        array $headers = [],
        $body = null,
        $version = '1.1',
        $reason = null
    ) {

        parent::__construct(
            $status,
            $headers,
            $body,
            $version,
            $reason
        );

        $this->message = $message ?? $this->getBody()->getContents();
    }

    public function getContents()
    {
        return [
            'Status_code' => $this->getStatusCode(),
            'Message' => $this->message,
        ];
    }
}

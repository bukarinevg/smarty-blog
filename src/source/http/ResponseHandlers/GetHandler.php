<?php
declare(strict_types=1);

namespace app\source\http\ResponseHandlers;


class GetHandler implements ResponseHandlerInterface
{
    public function handle(): void
    {
        http_response_code(200);
    }
}

<?php
declare(strict_types=1);

namespace app\source\http\ResponseHandlers;

interface ResponseHandlerInterface {
    public function handle(): void;
}

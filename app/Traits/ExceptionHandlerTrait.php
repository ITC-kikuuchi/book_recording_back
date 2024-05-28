<?php

declare(strict_types=1);

namespace App\Traits;

use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait ExceptionHandlerTrait
{
    use ResponseTrait;

}

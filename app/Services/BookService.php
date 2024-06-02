<?php

declare(strict_types=1);

namespace App\Services;

use App\Consts\PathConst;
use App\Models\Book;
use App\Repositories\Book\BookRepositoryInterface;
use App\Traits\ExceptionHandlerTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class BookService
{
    use ExceptionHandlerTrait;

}

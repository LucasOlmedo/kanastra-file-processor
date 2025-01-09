<?php

namespace App\Http\Controllers;

use App\Application\Services\DebtService;
use App\Http\Requests\UploadDebtRequest;

class DebtController extends Controller
{
    public function __construct(
        private DebtService $debtService
    ) {}

    public function uploadDebtFile(UploadDebtRequest $request) {}
}

<?php

namespace App\Infrastructure\Services;

use Illuminate\Support\Facades\Storage;

class ProcessDebtFileService
{
    const CHUNK_SIZE = 1000;

    public function readAndChunkDebtFile(string $filePath, int $chunkSize = self::CHUNK_SIZE) {}
}

<?php

namespace App\Infrastructure\Services;

use SplFileObject;

class ProcessDebtFileService
{
    private int $chunkSize;

    public function __construct()
    {
        $this->chunkSize = env('CHUNK_SIZE', 2000);
    }

    public function readAndChunkDebtFile(string $filePath)
    {
        $fileObject = new SplFileObject($filePath, 'r');
        $fileObject->setFlags(SplFileObject::READ_CSV);
        $header = $fileObject->fgetcsv();

        while (!$fileObject->eof()) {
            $chunk = $this->chunkCsv($fileObject, $header);
            if ($chunk)
                yield $chunk;
        }
    }

    private function chunkCsv(SplFileObject $fileObject, array $header): array
    {
        $chunk = [];
        while (count($chunk) < $this->chunkSize && !$fileObject->eof()) {
            $line = $fileObject->fgetcsv();
            if ($line !== [null])
                $chunk[] = array_combine($header, (array)$line);
        }
        return $chunk;
    }
}

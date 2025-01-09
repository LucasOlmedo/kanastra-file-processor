<?php

namespace App\Infrastructure\Services;

use SplFileObject;

class ProcessDebtFileService
{
    const CHUNK_SIZE = 5000;

    public function readAndChunkDebtFile(string $filePath)
    {
        $fileObject = new SplFileObject($filePath, 'r');
        $fileObject->setFlags(SplFileObject::READ_CSV);
        $fileObject->fgetcsv();

        while (!$fileObject->eof()) {
            $chunk = $this->chunkCsv($fileObject);
            if ($chunk)
                yield $chunk;
        }
    }

    private function chunkCsv(SplFileObject $fileObject): array
    {
        $chunk = [];
        while (count($chunk) < self::CHUNK_SIZE && !$fileObject->eof()) {
            $line = $fileObject->fgetcsv();
            if ($line !== [null])
                $chunk[] = $line;
        }
        return $chunk;
    }
}

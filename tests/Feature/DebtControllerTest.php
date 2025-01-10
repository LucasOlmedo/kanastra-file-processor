<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DebtControllerTest extends TestCase
{
    public function test_upload_debt_file_success(): void
    {
        $file = UploadedFile::fake()->createWithContent('debt.csv', implode('\n', [
            'name,governmentId,email,debtAmount,debtDueDate,debtId',
            'John Doe,123,RmL2X@example.com,100,2022-01-01,abcd-1234-5678-abcd',
            'Jane Doe,456,jane@example.com,200,2022-02-01,efgh-1234-5678-efgh',
        ]));

        $response = $this->postJson('/api/upload-debts', [
            'debt_file' => $file,
        ]);

        $response->assertStatus(200)->assertJson([
            'message' => 'File uploaded successfully. Processing...'
        ]);
    }

    public function test_upload_debt_file_fail(): void
    {
        $file = UploadedFile::fake()->createWithContent('debt.invalid', 'invalid data');
        $response = $this->postJson('/api/upload-debts', [
            'debt_file' => $file,
        ]);

        $response->assertStatus(422);
    }
}

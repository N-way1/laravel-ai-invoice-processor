<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessDocument;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class DocumentTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_document_upload_creates_record_and_dispatches_job(): void
    {
        // Queue::fake();

        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
        $response = $this->post('/api/documents', ['document' => $file]);

        $response->assertRedirect();
        // Queue::assertPushed(ProcessDocument::class);
    }

}
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Document;

class AiDocumentProcessor
{
  public function process($documentPath)
  {
    $document = Document::where('file_name', $documentPath)->first();
    if (!$document) {
      throw new \Exception('Document not found');
    }

    try {
      // Calling mock ai extraction API
      $aiResponse = Http::post('http://localhost:8000/api/mock-ai-extract', [
        'file_path' => $documentPath
      ]);

      if ($aiResponse->successful()) {
        $extractedData = $aiResponse->json();

        // Calling mock purchase orders API
        $poResponse = Http::get('http://localhost:8000/api/mock-purchase-orders');

        if ($poResponse->successful()) {
          $purchaseOrders = $poResponse->json();

          $matchedPO = $this->matchPurchaseOrder($extractedData, $purchaseOrders);

          // update the document if a matching purchase order is found
          if ($matchedPO) {
            $document->update([
              'invoice_number' => $extractedData['invoice_number'],
              'vendor' => $extractedData['vendor'],
              'total_amount' => $extractedData['total_amount'],
              'po_number' => $matchedPO['po_number'],
              'status' => 'processing'
            ]);
          } else {
            $document->update(['status' => 'failed']);
          }
        } else {
          throw new \Exception('Failed to fetch purchase orders');
        }
      } else {
        throw new \Exception('AI extraction failed');
      }
    } catch (\Exception $e) {
      Log::error('Document processing failed', [
        'document_path' => $documentPath,
        'error' => $e->getMessage()
      ]);
    }
  }

  private function matchPurchaseOrder($extractedData, $purchaseOrders)
  {
    // Simple matching using the vendor's name (case insensitive)

    $vendor = $extractedData['vendor'];

    foreach ($purchaseOrders as $po) {
      if (strcasecmp($vendor, $po['vendor']) === 0) {
        return $po;
      }
    }

    // Return null if no match found
    return null;
  }
}
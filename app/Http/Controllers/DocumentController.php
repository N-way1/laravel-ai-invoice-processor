<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Http\Requests\DocumentRequest;
use Illuminate\Http\Request;
use App\Jobs\ProcessDocument;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::orderBy('created_at', 'desc')->get();
        return response()->json($documents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentRequest $request)
    {
        $data = $request->validated();

        $path = $request->file('document')->store('documents');
        $data['file_name'] = $path;

        $document = Document::create($data);

        ProcessDocument::dispatch($document);

        return redirect()->back()->with('success', 'Document uploaded, processing started.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return response()->json($document);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
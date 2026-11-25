<?php

namespace App\Http\Controllers;

use App\Models\PurchaseAttachment;
use Illuminate\Support\Facades\Storage;

class PurchaseAttachmentController extends Controller
{
    public function show(PurchaseAttachment $attachment)
    {
        abort_unless(auth()->user()->can('purchases.view'), 403);

        return Storage::disk('private')->download(
            $attachment->file_path,
            $attachment->original_file_name ?: $attachment->stored_file_name,
        );
    }
}

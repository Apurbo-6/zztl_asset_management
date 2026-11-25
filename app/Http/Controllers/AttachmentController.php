<?php

namespace App\Http\Controllers;

use App\Models\AssetAttachment;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function show(AssetAttachment $attachment)
    {
        abort_unless(auth()->user()->can('assets.view'), 403);
        return Storage::disk('private')->download($attachment->file_path, $attachment->original_file_name ?: $attachment->stored_file_name);
    }
    public function destroy(AssetAttachment $attachment)
    {
        abort_unless(auth()->user()->can('assets.update'), 403);
        $name = $attachment->original_file_name;
        $asset = $attachment->asset_id;
        Storage::disk('private')->delete($attachment->file_path);
        $attachment->delete();
        \App\Support\Activity::record('deleted', 'assets', 'Deleted attachment ' . $name . ' from purchase record #' . $asset);
        return back()->with('success', 'Attachment deleted.');
    }
}

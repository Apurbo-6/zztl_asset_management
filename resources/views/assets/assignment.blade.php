@extends('layouts.app') @section('title','Asset assignment') @section('breadcrumb','Assets / Assignment') @section('content')<div class="page-heading">
    <div>
        <div class="eyebrow">ASSET OPERATIONS</div>
        <h1>Assignment · {{ $asset->asset_code }}</h1>
        <p class="muted">{{ $asset->product?->name }}</p>
    </div><a class="btn light" href="{{ route('assets.show',$asset) }}">← Back to asset</a>
</div>@if($asset->status==='available')<form class="panel form-panel" method="POST" action="{{ route('assets.assign',$asset) }}">@csrf<h2>Assign asset</h2>
    <div class="form-grid">
        <div class="field"><label>Employee *</label><select name="employee_id" required>
                <option value="">Select employee</option>@foreach($employees as $e)<option value="{{ $e->id }}">{{ $e->name }} ({{ $e->employee_code }})</option>@endforeach
            </select></div>
        <div class="field"><label>Department</label><select name="department_id">
                <option value="">Select department</option>@foreach($departments as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach
            </select></div>
        <div class="field"><label>Location</label><select name="location_id">
                <option value="">Select location</option>@foreach($locations as $l)<option value="{{ $l->id }}">{{ $l->name }}</option>@endforeach
            </select></div>
        <div class="field"><label>Assigned date *</label><input type="date" name="assigned_at" value="{{ now()->format('Y-m-d') }}" required></div>
        <div class="field full-field"><label>Notes</label><textarea name="notes"></textarea></div>
    </div>
    <div class="form-actions"><button class="btn primary">Confirm assignment</button></div>
</form>@elseif($asset->status==='assigned')<form class="panel form-panel" method="POST" action="{{ route('assets.return',$asset) }}">@csrf<h2>Record asset return</h2>
    <div class="form-grid">
        <div class="field"><label>Return date *</label><input type="date" name="returned_at" value="{{ now()->format('Y-m-d') }}" required></div>
        <div class="field"><label>Condition on return *</label><select name="return_condition" required>@foreach(['new','good','fair','damaged'] as $c)<option value="{{ $c }}">{{ ucfirst($c) }}</option>@endforeach</select></div>
        <div class="field full-field"><label>Return notes</label><textarea name="notes"></textarea></div>
    </div>
    <div class="form-actions"><button class="btn primary">Confirm return</button></div>
</form>@else<div class="panel">This asset must be available or assigned to use assignment actions.</div>@endif@endsection
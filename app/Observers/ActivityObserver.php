<?php
namespace App\Observers;
use App\Support\Activity;
use Illuminate\Database\Eloquent\Model;
class ActivityObserver
{
    public function created(Model $model): void { Activity::record('created', class_basename($model), $model::class, $model->getKey(), class_basename($model).' created', [], $model->getAttributes()); }
    public function updated(Model $model): void { Activity::record('updated', class_basename($model), $model::class, $model->getKey(), class_basename($model).' updated', $model->getOriginal(), $model->getChanges()); }
    public function deleted(Model $model): void { Activity::record('deleted', class_basename($model), $model::class, $model->getKey(), class_basename($model).' deleted', $model->getAttributes(), []); }
}

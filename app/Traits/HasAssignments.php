<?php

namespace App\Traits;

use App\Models\Assignment;
use App\Models\File;

trait HasAssignments
{
    public function assignments()
    {
        return $this->morphMany(Assignment::class, 'assignable');
    }

    public function addAssignment($assignment)
    {
        $this->assignments()->create($assignment);
    }

    public function removeAssignment($assignment)
    {
        $this->assignments()->where('id', $assignment->id)->delete();
    }

    public function removeAllAssignments()
    {
        $this->assignments()->delete();
    }
}

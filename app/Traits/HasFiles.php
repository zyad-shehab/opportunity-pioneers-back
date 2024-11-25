<?php

namespace App\Traits;

use App\Models\File;

trait HasFiles
{
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function addFile($file)
    {
        $this->files()->create($file);
    }

    public function removeFile($file)
    {
        $this->files()->where('id', $file->id)->delete();
    }

    public function removeAllFiles()
    {
        $this->files()->delete();
    }
}

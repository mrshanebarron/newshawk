<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    protected $guarded = [];

    public function topic() { return $this->belongsTo(Topic::class); }

    public function getStatusColorAttribute() {
        return match($this->status) {
            'completed' => 'emerald', 'running' => 'cyan', 'failed' => 'rose', default => 'slate'
        };
    }
}

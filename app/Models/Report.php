<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = [];
    protected $casts = ['topic_ids' => 'array', 'stats' => 'array', 'generated_at' => 'datetime'];

    public function getRouteKeyName() { return 'slug'; }

    public function getPeriodLabelAttribute() {
        return match($this->period) {
            'daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly', default => ucfirst($this->period)
        };
    }

    public function getPeriodColorAttribute() {
        return match($this->period) {
            'daily' => 'cyan', 'weekly' => 'amber', 'monthly' => 'violet', default => 'slate'
        };
    }
}

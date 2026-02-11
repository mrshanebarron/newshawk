<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $guarded = [];
    protected $casts = ['is_read' => 'boolean', 'triggered_at' => 'datetime'];

    public function topic() { return $this->belongsTo(Topic::class); }
    public function article() { return $this->belongsTo(Article::class); }

    public function getSeverityColorAttribute() {
        return match($this->severity) {
            'critical' => 'rose', 'warning' => 'amber', default => 'cyan'
        };
    }

    public function getSeverityIconAttribute() {
        return match($this->severity) {
            'critical' => '🔴', 'warning' => '🟡', default => '🔵'
        };
    }

    public function getTypeLabelAttribute() {
        return match($this->type) {
            'keyword_match' => 'Keyword Match', 'sentiment_shift' => 'Sentiment Shift',
            'volume_spike' => 'Volume Spike', 'breaking' => 'Breaking News', default => ucfirst($this->type)
        };
    }
}

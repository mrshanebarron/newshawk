<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean', 'last_scanned_at' => 'datetime'];

    public function getRouteKeyName() { return 'slug'; }

    public function articles() { return $this->belongsToMany(Article::class, 'article_topic')->withPivot('match_score')->withTimestamps(); }
    public function alerts() { return $this->hasMany(Alert::class); }
    public function scans() { return $this->hasMany(Scan::class); }

    public function getCategoryColorAttribute() {
        return match($this->category) {
            'tech' => 'cyan', 'finance' => 'emerald', 'politics' => 'amber',
            'health' => 'rose', 'science' => 'violet', 'sports' => 'orange',
            'world' => 'blue', default => 'slate'
        };
    }

    public function getCategoryIconAttribute() {
        return match($this->category) {
            'tech' => '⚡', 'finance' => '📈', 'politics' => '🏛️',
            'health' => '🏥', 'science' => '🔬', 'sports' => '🏆',
            'world' => '🌍', default => '📰'
        };
    }

    public function getFrequencyLabelAttribute() {
        return match($this->frequency) {
            'realtime' => 'Real-time', 'hourly' => 'Hourly', 'daily' => 'Daily', default => $this->frequency
        };
    }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean', 'reliability_score' => 'decimal:1'];

    public function getRouteKeyName() { return 'slug'; }

    public function articles() { return $this->hasMany(Article::class); }

    public function getReliabilityColorAttribute() {
        if ($this->reliability_score >= 8) return 'emerald';
        if ($this->reliability_score >= 6) return 'amber';
        return 'rose';
    }

    public function getReliabilityLabelAttribute() {
        if ($this->reliability_score >= 8) return 'High';
        if ($this->reliability_score >= 6) return 'Medium';
        return 'Low';
    }

    public function getCategoryLabelAttribute() {
        return match($this->category) {
            'mainstream' => 'Mainstream', 'tech' => 'Tech', 'financial' => 'Financial',
            'indie' => 'Independent', 'wire' => 'Wire Service', default => ucfirst($this->category ?? 'General')
        };
    }
}

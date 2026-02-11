<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];
    protected $casts = ['is_breaking' => 'boolean', 'is_bookmarked' => 'boolean', 'is_read' => 'boolean', 'published_at' => 'datetime', 'sentiment_score' => 'decimal:2', 'relevance_score' => 'decimal:2'];

    public function getRouteKeyName() { return 'slug'; }

    public function source() { return $this->belongsTo(Source::class); }
    public function topics() { return $this->belongsToMany(Topic::class, 'article_topic')->withPivot('match_score')->withTimestamps(); }
    public function alerts() { return $this->hasMany(Alert::class); }

    public function getSentimentColorAttribute() {
        if (!$this->sentiment_score) return 'slate';
        if ($this->sentiment_score > 0.2) return 'emerald';
        if ($this->sentiment_score < -0.2) return 'rose';
        return 'amber';
    }

    public function getSentimentIconAttribute() {
        if (!$this->sentiment_score) return '—';
        if ($this->sentiment_score > 0.2) return '↑';
        if ($this->sentiment_score < -0.2) return '↓';
        return '→';
    }

    public function getRelevanceLabelAttribute() {
        if ($this->relevance_score >= 80) return 'Critical';
        if ($this->relevance_score >= 60) return 'High';
        if ($this->relevance_score >= 40) return 'Medium';
        return 'Low';
    }

    public function getRelevanceColorAttribute() {
        if ($this->relevance_score >= 80) return 'rose';
        if ($this->relevance_score >= 60) return 'amber';
        if ($this->relevance_score >= 40) return 'cyan';
        return 'slate';
    }
}

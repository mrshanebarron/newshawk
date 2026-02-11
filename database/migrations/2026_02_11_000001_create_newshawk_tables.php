<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Topics to monitor (like Google Alerts keywords)
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('keywords'); // comma-separated search terms
            $table->string('category')->nullable(); // tech, finance, politics, health, etc.
            $table->string('color', 7)->default('#3b82f6');
            $table->boolean('is_active')->default(true);
            $table->string('frequency')->default('realtime'); // realtime, hourly, daily
            $table->integer('articles_count')->default(0);
            $table->timestamp('last_scanned_at')->nullable();
            $table->timestamps();
        });

        // News sources
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain');
            $table->string('logo_url')->nullable();
            $table->string('category')->nullable(); // mainstream, tech, financial, indie
            $table->decimal('reliability_score', 3, 1)->default(7.0); // 1-10
            $table->string('country')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('articles_count')->default(0);
            $table->timestamps();
        });

        // Scanned articles
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->text('content')->nullable();
            $table->string('url');
            $table->string('image_url')->nullable();
            $table->string('author')->nullable();
            $table->decimal('sentiment_score', 4, 2)->nullable(); // -1.0 to 1.0
            $table->string('sentiment_label')->nullable(); // positive, negative, neutral
            $table->decimal('relevance_score', 5, 2)->default(0); // AI relevance 0-100
            $table->boolean('is_breaking')->default(false);
            $table->boolean('is_bookmarked')->default(false);
            $table->boolean('is_read')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // Article-Topic pivot
        Schema::create('article_topic', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->decimal('match_score', 5, 2)->default(0); // how well it matches
            $table->timestamps();
        });

        // Alerts (notifications triggered by rules)
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('article_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type'); // keyword_match, sentiment_shift, volume_spike, breaking
            $table->string('severity')->default('info'); // info, warning, critical
            $table->string('title');
            $table->text('message')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('triggered_at');
            $table->timestamps();
        });

        // Scan history
        Schema::create('scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('articles_found')->default(0);
            $table->integer('new_articles')->default(0);
            $table->integer('sources_checked')->default(0);
            $table->decimal('duration_seconds', 6, 2)->default(0);
            $table->string('status')->default('completed'); // running, completed, failed
            $table->text('error_message')->nullable();
            $table->timestamps();
        });

        // Saved searches / reports
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->json('topic_ids')->nullable();
            $table->string('period'); // daily, weekly, monthly
            $table->json('stats')->nullable(); // cached analytics
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
        Schema::dropIfExists('scans');
        Schema::dropIfExists('alerts');
        Schema::dropIfExists('article_topic');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('sources');
        Schema::dropIfExists('topics');
    }
};

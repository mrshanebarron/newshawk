<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Topics
        $topics = [
            ['name' => 'AI & Machine Learning', 'slug' => 'ai-machine-learning', 'keywords' => 'artificial intelligence, machine learning, GPT, LLM, neural network, deep learning, OpenAI, Anthropic, Google DeepMind', 'category' => 'tech', 'color' => '#06b6d4', 'frequency' => 'realtime'],
            ['name' => 'Cybersecurity', 'slug' => 'cybersecurity', 'keywords' => 'data breach, ransomware, zero-day, CVE, vulnerability, hack, phishing, malware, threat actor', 'category' => 'tech', 'color' => '#f43f5e', 'frequency' => 'realtime'],
            ['name' => 'Federal Reserve', 'slug' => 'federal-reserve', 'keywords' => 'Fed, interest rates, FOMC, monetary policy, inflation, Jerome Powell, quantitative tightening', 'category' => 'finance', 'color' => '#10b981', 'frequency' => 'hourly'],
            ['name' => 'Climate Policy', 'slug' => 'climate-policy', 'keywords' => 'carbon emissions, COP, Paris Agreement, renewable energy, net zero, climate legislation, EPA', 'category' => 'politics', 'color' => '#f59e0b', 'frequency' => 'daily'],
            ['name' => 'Biotech Breakthroughs', 'slug' => 'biotech-breakthroughs', 'keywords' => 'CRISPR, gene therapy, FDA approval, clinical trials, mRNA, drug discovery, precision medicine', 'category' => 'health', 'color' => '#8b5cf6', 'frequency' => 'daily'],
            ['name' => 'Space Exploration', 'slug' => 'space-exploration', 'keywords' => 'SpaceX, NASA, Artemis, satellite, orbit, Mars, lunar, rocket launch, ISS', 'category' => 'science', 'color' => '#3b82f6', 'frequency' => 'daily'],
            ['name' => 'US-China Relations', 'slug' => 'us-china-relations', 'keywords' => 'trade war, tariffs, sanctions, Taiwan, semiconductor, export controls, diplomacy', 'category' => 'world', 'color' => '#f97316', 'frequency' => 'hourly'],
            ['name' => 'Crypto Markets', 'slug' => 'crypto-markets', 'keywords' => 'Bitcoin, Ethereum, cryptocurrency, blockchain, DeFi, SEC regulation, stablecoin, crypto ETF', 'category' => 'finance', 'color' => '#eab308', 'frequency' => 'realtime'],
        ];

        foreach ($topics as $topic) {
            $topic['is_active'] = true;
            $topic['articles_count'] = 0;
            $topic['last_scanned_at'] = now()->subMinutes(rand(5, 120));
            $topic['created_at'] = now();
            $topic['updated_at'] = now();
            DB::table('topics')->insert($topic);
        }

        // Sources
        $sources = [
            ['name' => 'Reuters', 'slug' => 'reuters', 'domain' => 'reuters.com', 'category' => 'wire', 'reliability_score' => 9.2, 'country' => 'UK'],
            ['name' => 'Associated Press', 'slug' => 'associated-press', 'domain' => 'apnews.com', 'category' => 'wire', 'reliability_score' => 9.0, 'country' => 'US'],
            ['name' => 'Bloomberg', 'slug' => 'bloomberg', 'domain' => 'bloomberg.com', 'category' => 'financial', 'reliability_score' => 8.8, 'country' => 'US'],
            ['name' => 'TechCrunch', 'slug' => 'techcrunch', 'domain' => 'techcrunch.com', 'category' => 'tech', 'reliability_score' => 7.5, 'country' => 'US'],
            ['name' => 'The Verge', 'slug' => 'the-verge', 'domain' => 'theverge.com', 'category' => 'tech', 'reliability_score' => 7.2, 'country' => 'US'],
            ['name' => 'Ars Technica', 'slug' => 'ars-technica', 'domain' => 'arstechnica.com', 'category' => 'tech', 'reliability_score' => 8.1, 'country' => 'US'],
            ['name' => 'Financial Times', 'slug' => 'financial-times', 'domain' => 'ft.com', 'category' => 'financial', 'reliability_score' => 9.1, 'country' => 'UK'],
            ['name' => 'BBC News', 'slug' => 'bbc-news', 'domain' => 'bbc.com', 'category' => 'mainstream', 'reliability_score' => 8.5, 'country' => 'UK'],
            ['name' => 'The Guardian', 'slug' => 'the-guardian', 'domain' => 'theguardian.com', 'category' => 'mainstream', 'reliability_score' => 7.8, 'country' => 'UK'],
            ['name' => 'Wired', 'slug' => 'wired', 'domain' => 'wired.com', 'category' => 'tech', 'reliability_score' => 7.6, 'country' => 'US'],
            ['name' => 'CNBC', 'slug' => 'cnbc', 'domain' => 'cnbc.com', 'category' => 'financial', 'reliability_score' => 7.4, 'country' => 'US'],
            ['name' => 'Al Jazeera', 'slug' => 'al-jazeera', 'domain' => 'aljazeera.com', 'category' => 'mainstream', 'reliability_score' => 7.0, 'country' => 'Qatar'],
            ['name' => 'The Information', 'slug' => 'the-information', 'domain' => 'theinformation.com', 'category' => 'tech', 'reliability_score' => 8.7, 'country' => 'US'],
            ['name' => 'Nature', 'slug' => 'nature', 'domain' => 'nature.com', 'category' => 'indie', 'reliability_score' => 9.5, 'country' => 'UK'],
            ['name' => 'CoinDesk', 'slug' => 'coindesk', 'domain' => 'coindesk.com', 'category' => 'financial', 'reliability_score' => 6.8, 'country' => 'US'],
        ];

        foreach ($sources as $source) {
            $source['is_active'] = true;
            $source['articles_count'] = 0;
            $source['created_at'] = now();
            $source['updated_at'] = now();
            DB::table('sources')->insert($source);
        }

        // Articles
        $articles = [
            [
                'source_id' => 4, 'title' => 'Anthropic Unveils Claude 4.5 with Breakthrough Reasoning Capabilities',
                'slug' => 'anthropic-unveils-claude-45', 'summary' => 'Anthropic releases its most capable model yet, demonstrating significant advances in multi-step reasoning, code generation, and safety alignment.',
                'content' => "Anthropic announced today the release of Claude 4.5, marking a significant leap forward in large language model capabilities. The new model demonstrates marked improvements in multi-step reasoning tasks, mathematical problem solving, and code generation, while maintaining the company's signature focus on safety and alignment.\n\nIn benchmarks shared by the company, Claude 4.5 outperformed previous versions across all major evaluation categories, with particularly notable gains in graduate-level reasoning tasks where it achieved a 94.2% accuracy rate.\n\nThe release comes amid intensifying competition in the AI industry, with major players racing to develop increasingly capable models while grappling with questions of safety, regulation, and societal impact.",
                'url' => 'https://techcrunch.com/example/anthropic-claude-45', 'author' => 'Sarah Chen',
                'sentiment_score' => 0.65, 'sentiment_label' => 'positive', 'relevance_score' => 95.5,
                'is_breaking' => true, 'published_at' => now()->subHours(2),
                'topic_ids' => [1], 'match_scores' => [92.0],
            ],
            [
                'source_id' => 6, 'title' => 'Google DeepMind Achieves Protein Folding Prediction at Atomic Scale',
                'slug' => 'deepmind-protein-folding-atomic', 'summary' => 'New AlphaFold variant predicts protein structures at atomic resolution, opening doors for drug discovery.',
                'content' => "Google DeepMind has pushed the boundaries of computational biology with a new iteration of AlphaFold that achieves atomic-scale accuracy in protein structure prediction. The advance could dramatically accelerate drug discovery timelines.\n\nResearchers demonstrated the system's ability to predict not just the overall fold of proteins, but the precise positions of individual atoms within the structure, including water molecules that play crucial roles in protein function.\n\nThe pharmaceutical industry has responded enthusiastically, with several major drug companies announcing plans to integrate the technology into their discovery pipelines.",
                'url' => 'https://arstechnica.com/example/deepmind-protein', 'author' => 'John Timmer',
                'sentiment_score' => 0.72, 'sentiment_label' => 'positive', 'relevance_score' => 88.0,
                'is_breaking' => false, 'published_at' => now()->subHours(5),
                'topic_ids' => [1, 5], 'match_scores' => [85.0, 78.0],
            ],
            [
                'source_id' => 13, 'title' => 'OpenAI Internal Tensions Rise Over Commercialization Speed',
                'slug' => 'openai-internal-tensions-commercialization', 'summary' => 'Sources within OpenAI describe growing disagreements about the pace of product launches and safety review processes.',
                'content' => "Multiple sources within OpenAI have described escalating internal debates about the company's rapid commercialization strategy and its potential impact on safety protocols. The tensions mirror broader industry concerns about the speed at which AI capabilities are being deployed to consumers.\n\nAccording to three current employees who spoke on condition of anonymity, several senior safety researchers have raised concerns about compressed review timelines for new product features. The company's leadership maintains that their safety processes remain rigorous despite accelerated deployment schedules.\n\nThe revelations come as Congress prepares to hear testimony from AI executives about industry safety practices next month.",
                'url' => 'https://theinformation.com/example/openai-tensions', 'author' => 'Wayne Ma',
                'sentiment_score' => -0.35, 'sentiment_label' => 'negative', 'relevance_score' => 82.0,
                'is_breaking' => false, 'published_at' => now()->subHours(8),
                'topic_ids' => [1], 'match_scores' => [79.0],
            ],
            [
                'source_id' => 6, 'title' => 'Critical Zero-Day in Enterprise VPN Appliances Actively Exploited',
                'slug' => 'critical-zero-day-vpn-appliances', 'summary' => 'CISA issues emergency directive after discovering state-sponsored exploitation of previously unknown vulnerability in widely-deployed VPN hardware.',
                'content' => "The Cybersecurity and Infrastructure Security Agency (CISA) has issued an emergency directive requiring all federal agencies to immediately patch or disconnect affected VPN appliances following the discovery of active exploitation of a critical zero-day vulnerability.\n\nThe vulnerability, tracked as CVE-2026-4821, affects enterprise VPN products from a major vendor and allows unauthenticated remote code execution. Threat intelligence firms have attributed the exploitation campaign to a state-sponsored threat actor.\n\nOrganizations using the affected products are urged to apply the emergency patch released today or implement the provided mitigation guidance immediately.",
                'url' => 'https://arstechnica.com/example/vpn-zero-day', 'author' => 'Dan Goodin',
                'sentiment_score' => -0.68, 'sentiment_label' => 'negative', 'relevance_score' => 97.0,
                'is_breaking' => true, 'published_at' => now()->subHour(),
                'topic_ids' => [2], 'match_scores' => [96.0],
            ],
            [
                'source_id' => 8, 'title' => 'Major Healthcare Chain Reports Ransomware Attack Affecting 2.3M Records',
                'slug' => 'healthcare-chain-ransomware-attack', 'summary' => 'Patient data compromised in ransomware attack on one of the largest US hospital networks.',
                'content' => "One of the nation's largest healthcare providers disclosed today that a ransomware attack last month compromised the personal and medical data of approximately 2.3 million patients across 47 facilities.\n\nThe attack, attributed to a ransomware group known as BlackCat/ALPHV, encrypted critical systems and exfiltrated data including patient names, Social Security numbers, medical histories, and insurance information.\n\nThe company says it has restored most systems from backups but acknowledged that the exfiltrated data may be leaked if ransom demands are not met. Federal investigators and private cybersecurity firms are assisting with the response.",
                'url' => 'https://bbc.com/example/healthcare-ransomware', 'author' => 'Joe Tidy',
                'sentiment_score' => -0.82, 'sentiment_label' => 'negative', 'relevance_score' => 91.0,
                'is_breaking' => true, 'published_at' => now()->subHours(3),
                'topic_ids' => [2, 5], 'match_scores' => [94.0, 45.0],
            ],
            [
                'source_id' => 3, 'title' => 'Fed Minutes Reveal Division on Rate Path as Inflation Data Stalls',
                'slug' => 'fed-minutes-division-rate-path', 'summary' => 'FOMC meeting minutes show growing disagreement among policymakers about the appropriate pace of rate adjustments.',
                'content' => "Minutes from the Federal Reserve's latest policy meeting reveal a deepening split among committee members about the future path of interest rates, with some advocating for patience while others push for action in response to sticky inflation readings.\n\nThe documents show that several participants expressed concern about inflation metrics that have remained above the 2% target longer than initially projected, while others pointed to signs of labor market cooling that could warrant a more accommodative stance.\n\nMarkets reacted modestly to the release, with Treasury yields ticking higher as investors recalibrated expectations for the timing and magnitude of future rate moves.",
                'url' => 'https://bloomberg.com/example/fed-minutes', 'author' => 'Craig Torres',
                'sentiment_score' => -0.15, 'sentiment_label' => 'neutral', 'relevance_score' => 89.0,
                'is_breaking' => false, 'published_at' => now()->subHours(6),
                'topic_ids' => [3], 'match_scores' => [95.0],
            ],
            [
                'source_id' => 7, 'title' => 'Bank of England Surprises with 50 Basis Point Cut Amid Growth Fears',
                'slug' => 'boe-surprise-rate-cut', 'summary' => 'BOE delivers larger-than-expected rate reduction as UK economic data deteriorates sharply.',
                'content' => "The Bank of England shocked financial markets today with a 50 basis point interest rate cut, double the 25 basis points that most economists had predicted, citing a significant deterioration in the UK economic outlook.\n\nGovernor Andrew Bailey stated that the bank's decision reflected new data showing the economy contracting more sharply than previous forecasts suggested, with particular weakness in consumer spending and business investment.\n\nThe pound fell 1.2% against the dollar immediately following the announcement, while UK government bond yields dropped sharply across the curve.",
                'url' => 'https://ft.com/example/boe-rate-cut', 'author' => 'Chris Giles',
                'sentiment_score' => -0.28, 'sentiment_label' => 'negative', 'relevance_score' => 72.0,
                'is_breaking' => false, 'published_at' => now()->subHours(10),
                'topic_ids' => [3], 'match_scores' => [65.0],
            ],
            [
                'source_id' => 9, 'title' => 'EU Passes Landmark Carbon Border Tax Implementation Rules',
                'slug' => 'eu-carbon-border-tax-implementation', 'summary' => 'European Parliament finalizes the detailed rules for implementing the world\'s first carbon border adjustment mechanism.',
                'content' => "The European Parliament has voted to approve the detailed implementation rules for the Carbon Border Adjustment Mechanism (CBAM), marking a milestone in global climate policy.\n\nThe mechanism will impose carbon tariffs on imports of steel, cement, aluminum, fertilizers, electricity, and hydrogen from countries that lack equivalent carbon pricing systems. The full levy will phase in gradually starting in 2027.\n\nThe decision has drawn both praise from environmental groups and criticism from trading partners, with several developing nations arguing the mechanism amounts to protectionism disguised as climate action.",
                'url' => 'https://theguardian.com/example/eu-carbon-tax', 'author' => 'Jennifer Rankin',
                'sentiment_score' => 0.25, 'sentiment_label' => 'positive', 'relevance_score' => 85.0,
                'is_breaking' => false, 'published_at' => now()->subHours(14),
                'topic_ids' => [4], 'match_scores' => [91.0],
            ],
            [
                'source_id' => 14, 'title' => 'CRISPR Gene Therapy Shows Complete Remission in Sickle Cell Trial',
                'slug' => 'crispr-sickle-cell-complete-remission', 'summary' => 'Phase 3 clinical results show 100% of treated patients achieved sustained remission from sickle cell disease symptoms.',
                'content' => "Results from a pivotal Phase 3 clinical trial published today in Nature Medicine demonstrate that a one-time CRISPR-based gene therapy achieved complete and sustained remission in all 45 patients treated for severe sickle cell disease.\n\nPatients who received the therapy, designated CTX001, showed elimination of vaso-occlusive crises and no longer required blood transfusions, with benefits sustained for more than 24 months in the longest-followed patients.\n\nThe results are expected to accelerate the already-submitted regulatory applications in the US, EU, and UK, with FDA approval potentially coming within months.",
                'url' => 'https://nature.com/example/crispr-sickle-cell', 'author' => 'Heidi Ledford',
                'sentiment_score' => 0.88, 'sentiment_label' => 'positive', 'relevance_score' => 93.0,
                'is_breaking' => false, 'published_at' => now()->subHours(18),
                'topic_ids' => [5], 'match_scores' => [97.0],
            ],
            [
                'source_id' => 1, 'title' => 'SpaceX Successfully Tests Starship Orbital Refueling Prototype',
                'slug' => 'spacex-starship-orbital-refueling', 'summary' => 'Critical NASA Artemis requirement demonstrated in orbit for the first time.',
                'content' => "SpaceX has successfully demonstrated the transfer of cryogenic propellant between two Starship vehicles in low Earth orbit, achieving a critical milestone for NASA's Artemis lunar program.\n\nThe test, which took place over six hours, involved the transfer of approximately 10 metric tons of liquid oxygen between two unmanned Starship spacecraft at an altitude of 250 kilometers. The achievement is a prerequisite for the Human Landing System variant of Starship, which will require multiple refueling operations in orbit before traveling to the Moon.\n\nNASA Administrator praised the achievement, calling it a significant step toward sustainable lunar exploration.",
                'url' => 'https://reuters.com/example/spacex-refueling', 'author' => 'Joey Roulette',
                'sentiment_score' => 0.71, 'sentiment_label' => 'positive', 'relevance_score' => 87.0,
                'is_breaking' => false, 'published_at' => now()->subHours(22),
                'topic_ids' => [6], 'match_scores' => [93.0],
            ],
            [
                'source_id' => 2, 'title' => 'US Expands Semiconductor Export Controls to Include AI Chip Peripherals',
                'slug' => 'us-expands-semiconductor-export-controls', 'summary' => 'Commerce Department broadens chip export restrictions to cover high-bandwidth memory and advanced packaging equipment.',
                'content' => "The US Commerce Department announced expanded export controls targeting the semiconductor supply chain, extending restrictions beyond cutting-edge AI chips to include high-bandwidth memory (HBM) modules and advanced chip packaging equipment.\n\nThe new rules are designed to close loopholes that have allowed Chinese companies to assemble AI computing systems using components that weren't individually restricted under previous regulations. Industry analysts say the measures could significantly impact China's ability to develop domestic AI infrastructure.\n\nBeijing responded sharply, calling the expansion a violation of free trade principles and hinting at retaliatory measures targeting American companies operating in China.",
                'url' => 'https://apnews.com/example/semiconductor-controls', 'author' => 'Zen Soo',
                'sentiment_score' => -0.42, 'sentiment_label' => 'negative', 'relevance_score' => 90.0,
                'is_breaking' => false, 'published_at' => now()->subHours(12),
                'topic_ids' => [7, 1], 'match_scores' => [88.0, 72.0],
            ],
            [
                'source_id' => 15, 'title' => 'Bitcoin Spot ETF Inflows Surpass $2B in Single Week as BTC Nears ATH',
                'slug' => 'bitcoin-spot-etf-inflows-record', 'summary' => 'Institutional demand for Bitcoin spot ETFs reaches new weekly record as the cryptocurrency approaches its all-time high.',
                'content' => "Net inflows into US-listed Bitcoin spot ETFs exceeded \$2 billion over the past five trading days, setting a new weekly record and pushing total assets under management past \$85 billion.\n\nBlackRock's iShares Bitcoin Trust (IBIT) accounted for approximately \$1.3 billion of the weekly inflows, maintaining its position as the dominant product. Bitcoin itself traded above \$98,000, within striking distance of the psychological \$100,000 level.\n\nAnalysts attribute the surge to a combination of macroeconomic factors, including expectations of looser monetary policy, and growing institutional adoption as financial advisors increasingly allocate client assets to the category.",
                'url' => 'https://coindesk.com/example/btc-etf-inflows', 'author' => 'Omkar Godbole',
                'sentiment_score' => 0.58, 'sentiment_label' => 'positive', 'relevance_score' => 86.0,
                'is_breaking' => false, 'published_at' => now()->subHours(4),
                'topic_ids' => [8], 'match_scores' => [94.0],
            ],
            [
                'source_id' => 10, 'title' => 'The Hidden Environmental Cost of Training Large Language Models',
                'slug' => 'environmental-cost-training-llm', 'summary' => 'New research quantifies the water and energy consumption of frontier AI model training runs.',
                'content' => "A comprehensive study published this week has attempted to quantify the full environmental footprint of training frontier large language models, including factors often overlooked in previous analyses such as water consumption for data center cooling, the embodied carbon of specialized hardware, and the energy cost of the extensive evaluation and red-teaming processes.\n\nThe research estimates that training a single frontier model requires approximately 25 million liters of water and produces carbon emissions equivalent to 300 transatlantic flights. However, the authors note that these costs should be weighed against the potential efficiency gains enabled by AI applications across industries.",
                'url' => 'https://wired.com/example/llm-environmental-cost', 'author' => 'Will Knight',
                'sentiment_score' => -0.22, 'sentiment_label' => 'neutral', 'relevance_score' => 75.0,
                'is_breaking' => false, 'published_at' => now()->subDay(),
                'topic_ids' => [1, 4], 'match_scores' => [70.0, 65.0],
            ],
            [
                'source_id' => 11, 'title' => 'SEC Announces Framework for Stablecoin Regulation',
                'slug' => 'sec-stablecoin-regulation-framework', 'summary' => 'Securities regulator outlines comprehensive approach to stablecoin oversight, seeking to balance innovation with consumer protection.',
                'content' => "The Securities and Exchange Commission today released a detailed regulatory framework for stablecoins, providing the most comprehensive guidance to date on how the agency intends to regulate the rapidly growing category of digital assets.\n\nThe framework distinguishes between payment stablecoins, which it proposes to regulate under a lighter-touch regime, and stablecoins that function as investment contracts, which would face full securities regulation. The guidance also addresses reserve requirements, redemption rights, and disclosure obligations.\n\nIndustry groups gave the framework a cautiously positive reception, with several major stablecoin issuers noting that the clarity, while stricter in some areas than hoped, provides a workable path forward.",
                'url' => 'https://cnbc.com/example/sec-stablecoin', 'author' => 'MacKenzie Sigalos',
                'sentiment_score' => 0.12, 'sentiment_label' => 'neutral', 'relevance_score' => 80.0,
                'is_breaking' => false, 'published_at' => now()->subHours(16),
                'topic_ids' => [8], 'match_scores' => [88.0],
            ],
            [
                'source_id' => 12, 'title' => 'Taiwan Strait Tensions Escalate After Unprecedented Military Exercises',
                'slug' => 'taiwan-strait-tensions-military-exercises', 'summary' => 'PLA conducts largest-ever simulated blockade exercise near Taiwan, drawing sharp international response.',
                'content' => "China's People's Liberation Army conducted what military analysts are calling its largest and most complex military exercise in the Taiwan Strait to date, involving over 70 naval vessels, 100 aircraft, and simulated amphibious landing operations.\n\nThe exercises, which continued for four days, effectively established temporary exclusion zones in areas normally used for commercial shipping, causing significant disruption to one of the world's busiest maritime trade routes.\n\nThe United States, Japan, and Australia issued a joint statement expressing concern about the exercises, while Taiwan's defense ministry reported that it had maintained continuous surveillance and readiness throughout the period.",
                'url' => 'https://aljazeera.com/example/taiwan-strait-exercises', 'author' => 'David Crawshaw',
                'sentiment_score' => -0.72, 'sentiment_label' => 'negative', 'relevance_score' => 88.0,
                'is_breaking' => false, 'published_at' => now()->subHours(20),
                'topic_ids' => [7], 'match_scores' => [90.0],
            ],
            [
                'source_id' => 5, 'title' => 'Microsoft and Google Race to Embed AI Agents Directly in Operating Systems',
                'slug' => 'microsoft-google-ai-agents-os', 'summary' => 'Both tech giants announce plans to integrate persistent AI assistants at the OS level, raising questions about competition and privacy.',
                'content' => "In parallel announcements this week, Microsoft and Google revealed ambitious plans to embed AI agent capabilities directly into their respective operating systems, moving beyond standalone applications to create persistent, system-level AI assistants.\n\nMicrosoft's approach integrates deeply with Windows, allowing the AI agent to control applications, manage files, and automate workflows across the desktop. Google's version focuses on Chrome OS and Android, with emphasis on cross-device continuity and integration with Google's cloud services.\n\nThe announcements have triggered discussions about market competition, data privacy implications, and the potential for these embedded agents to reshape how users interact with their devices.",
                'url' => 'https://theverge.com/example/ai-agents-os', 'author' => 'Tom Warren',
                'sentiment_score' => 0.30, 'sentiment_label' => 'positive', 'relevance_score' => 83.0,
                'is_breaking' => false, 'published_at' => now()->subHours(7),
                'topic_ids' => [1], 'match_scores' => [86.0],
            ],
        ];

        foreach ($articles as $articleData) {
            $topicIds = $articleData['topic_ids'];
            $matchScores = $articleData['match_scores'];
            unset($articleData['topic_ids'], $articleData['match_scores']);

            $articleData['is_bookmarked'] = rand(0, 4) === 0;
            $articleData['is_read'] = rand(0, 2) !== 0;
            $articleData['created_at'] = $articleData['published_at'];
            $articleData['updated_at'] = $articleData['published_at'];

            $articleId = DB::table('articles')->insertGetId($articleData);

            foreach ($topicIds as $i => $topicId) {
                DB::table('article_topic')->insert([
                    'article_id' => $articleId,
                    'topic_id' => $topicId,
                    'match_score' => $matchScores[$i],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Update article counts
        $topicCounts = DB::table('article_topic')
            ->select('topic_id', DB::raw('count(*) as cnt'))
            ->groupBy('topic_id')
            ->get();

        foreach ($topicCounts as $tc) {
            DB::table('topics')->where('id', $tc->topic_id)->update(['articles_count' => $tc->cnt]);
        }

        $sourceCounts = DB::table('articles')
            ->select('source_id', DB::raw('count(*) as cnt'))
            ->groupBy('source_id')
            ->get();

        foreach ($sourceCounts as $sc) {
            DB::table('sources')->where('id', $sc->source_id)->update(['articles_count' => $sc->cnt]);
        }

        // Alerts
        $alerts = [
            ['topic_id' => 2, 'article_id' => 4, 'type' => 'breaking', 'severity' => 'critical', 'title' => 'Critical Zero-Day Alert', 'message' => 'Active exploitation of enterprise VPN vulnerability detected. CISA emergency directive issued.', 'triggered_at' => now()->subHour()],
            ['topic_id' => 2, 'article_id' => 5, 'type' => 'breaking', 'severity' => 'critical', 'title' => 'Major Data Breach Reported', 'message' => '2.3 million patient records compromised in ransomware attack on healthcare chain.', 'triggered_at' => now()->subHours(3)],
            ['topic_id' => 1, 'article_id' => 1, 'type' => 'keyword_match', 'severity' => 'info', 'title' => 'New Anthropic Model Release', 'message' => 'Claude 4.5 announced with breakthrough reasoning capabilities. Matches: Anthropic, LLM, deep learning.', 'triggered_at' => now()->subHours(2)],
            ['topic_id' => 8, 'article_id' => 12, 'type' => 'volume_spike', 'severity' => 'warning', 'title' => 'Crypto Volume Spike', 'message' => 'Bitcoin ETF discussion volume up 340% in the last 6 hours. 14 articles detected across 8 sources.', 'triggered_at' => now()->subHours(4)],
            ['topic_id' => 7, 'article_id' => 15, 'type' => 'sentiment_shift', 'severity' => 'warning', 'title' => 'Sentiment Shift: US-China', 'message' => 'Topic sentiment dropped from -0.15 to -0.58 over 24 hours. Taiwan strait tensions driving negative coverage.', 'triggered_at' => now()->subHours(8)],
            ['topic_id' => 3, 'article_id' => 6, 'type' => 'keyword_match', 'severity' => 'info', 'title' => 'FOMC Minutes Released', 'message' => 'Fed minutes reveal policy division. Matches: FOMC, interest rates, inflation, monetary policy.', 'triggered_at' => now()->subHours(6)],
            ['topic_id' => 1, 'article_id' => 3, 'type' => 'sentiment_shift', 'severity' => 'info', 'title' => 'AI Safety Concerns Rising', 'message' => 'Negative sentiment articles about AI safety up 28% this week. OpenAI internal tensions story trending.', 'triggered_at' => now()->subHours(9)],
            ['topic_id' => 5, 'article_id' => 9, 'type' => 'keyword_match', 'severity' => 'info', 'title' => 'CRISPR Breakthrough Reported', 'message' => 'Phase 3 sickle cell results published in Nature Medicine. 100% remission rate. Matches: CRISPR, gene therapy, clinical trials.', 'triggered_at' => now()->subHours(18)],
        ];

        foreach ($alerts as $alert) {
            $alert['is_read'] = rand(0, 2) === 0;
            $alert['created_at'] = $alert['triggered_at'];
            $alert['updated_at'] = $alert['triggered_at'];
            DB::table('alerts')->insert($alert);
        }

        // Scans
        $scans = [
            ['topic_id' => 1, 'articles_found' => 47, 'new_articles' => 6, 'sources_checked' => 15, 'duration_seconds' => 12.4, 'status' => 'completed', 'created_at' => now()->subMinutes(8)],
            ['topic_id' => 2, 'articles_found' => 31, 'new_articles' => 3, 'sources_checked' => 15, 'duration_seconds' => 9.7, 'status' => 'completed', 'created_at' => now()->subMinutes(12)],
            ['topic_id' => 3, 'articles_found' => 22, 'new_articles' => 2, 'sources_checked' => 12, 'duration_seconds' => 7.2, 'status' => 'completed', 'created_at' => now()->subMinutes(35)],
            ['topic_id' => 8, 'articles_found' => 38, 'new_articles' => 8, 'sources_checked' => 10, 'duration_seconds' => 11.1, 'status' => 'completed', 'created_at' => now()->subMinutes(45)],
            ['topic_id' => 7, 'articles_found' => 19, 'new_articles' => 1, 'sources_checked' => 14, 'duration_seconds' => 8.5, 'status' => 'completed', 'created_at' => now()->subHour()],
            ['topic_id' => null, 'articles_found' => 156, 'new_articles' => 24, 'sources_checked' => 15, 'duration_seconds' => 34.8, 'status' => 'completed', 'created_at' => now()->subHours(2)],
            ['topic_id' => 4, 'articles_found' => 15, 'new_articles' => 0, 'sources_checked' => 11, 'duration_seconds' => 6.3, 'status' => 'completed', 'created_at' => now()->subHours(3)],
            ['topic_id' => 5, 'articles_found' => 12, 'new_articles' => 1, 'sources_checked' => 8, 'duration_seconds' => 5.1, 'status' => 'completed', 'created_at' => now()->subHours(4)],
        ];

        foreach ($scans as $scan) {
            $scan['updated_at'] = $scan['created_at'];
            DB::table('scans')->insert($scan);
        }

        // Reports
        $reports = [
            [
                'title' => 'Weekly AI Intelligence Brief', 'slug' => 'weekly-ai-brief',
                'description' => 'Comprehensive weekly summary of AI developments, model releases, policy discussions, and market impact.',
                'topic_ids' => json_encode([1]), 'period' => 'weekly',
                'stats' => json_encode(['articles_analyzed' => 47, 'avg_sentiment' => 0.18, 'top_source' => 'TechCrunch', 'key_trend' => 'Increasing focus on AI safety and regulation']),
                'generated_at' => now()->subDay(),
            ],
            [
                'title' => 'Daily Security Threat Summary', 'slug' => 'daily-security-threats',
                'description' => 'Daily digest of cybersecurity incidents, vulnerabilities, and threat intelligence updates.',
                'topic_ids' => json_encode([2]), 'period' => 'daily',
                'stats' => json_encode(['articles_analyzed' => 31, 'critical_alerts' => 2, 'new_cves' => 5, 'key_threat' => 'VPN zero-day exploitation campaign']),
                'generated_at' => now()->subHours(6),
            ],
            [
                'title' => 'Monthly Macro Economic Overview', 'slug' => 'monthly-macro-overview',
                'description' => 'Monthly analysis of central bank activity, market movements, and economic policy shifts.',
                'topic_ids' => json_encode([3, 8]), 'period' => 'monthly',
                'stats' => json_encode(['articles_analyzed' => 124, 'avg_sentiment' => -0.08, 'rate_changes' => 2, 'key_event' => 'BOE surprise rate cut']),
                'generated_at' => now()->subDays(3),
            ],
        ];

        foreach ($reports as $report) {
            $report['created_at'] = now();
            $report['updated_at'] = now();
            DB::table('reports')->insert($report);
        }
    }
}

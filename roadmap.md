🗺️ Samah Care — Full Development Roadmap
Professional Ad Intelligence & Growth Platform
جدول المحتويات
 1. Executive Summary & Vision
 2. Current vs Target Architecture
 3. Phase 1: Foundation (Days 1-7)
 4. Phase 2: CAPI & Compliance (Days 8-14)
 5. Phase 3: Intelligence Core (Days 15-28)
 6. Phase 4: Automation Engines (Days 29-42)
 7. Phase 5: Unified Command (Days 43-56)
 8. Phase 6: Growth Acceleration (Days 57-70)
 9. Complete Database Schema
10. Complete Route Registry
11. Testing Matrix
12. Deployment & Monitoring
1. Executive Summary
Current State
Samah Care has a powerful but incomplete advertising ecosystem. Meta Ads has full CRUD + CAPI, but the other 6 platforms (TikTok, Google, Snapchat, Pinterest, Twitter, LinkedIn) are browser-pixel only with no campaign management. Three subsystems are 100% stubs (MetaLeadHub, SEO, Bulk Campaigns). CAPI is only wired for Facebook and TikTok despite full services existing for all 7 platforms.
Target State
A unified ad intelligence command center that manages all 7 platforms from one dashboard, with AI-powered creative generation, predictive campaign simulation, cross-platform budget optimization, intelligent audience building, and complete server-side conversion tracking. The platform becomes the brain that makes advertising decisions, not just a dashboard that reports them.
Key Metrics Target
Metric	Current
ROAS	~2-3x
CPA	Baseline
Attribution Rate	~30%
Creative Production	Manual
Platform Coverage	Meta only management
Admin Decision Time	Hours/day
2. Architecture: Current → Target
CURRENT:                          TARGET:
─────────                         ──────
Meta ←→ CRUD + CAPI               ALL 7 ←→ CRUD + CAPI
TikTok ← Pixel only              Cross-Platform Budget Optimizer
Google ← Pixel only              AI Creative Copilot
Snapchat ← Pixel only            DCO Engine (auto-rotate)
Pinterest ← Pixel only           Intelligent Audience Builder
Twitter ← Pixel only             Attribution 3.0 (Markov)
LinkedIn ← Pixel only            Campaign Simulator (ML)
                                  Competitor Intelligence
MetaLeadHub → STUB               Lead Hub → FULL (WhatsApp)
SEO → STUB                       SEO → AI-Powered
Auto-Pause → Meta only           Auto-Pause → All 7 platforms
ROAS → Simple spend/revenue      ROAS → Attribution-weighted
Predictive → Basic LTV           Predictive → Full ML pipeline
3. Phase 1: Foundation — Days 1-7
Goal: Complete the tracking backbone. Wire every platform's CAPI. Fix stubs.
Module 1A: CAPI Completion (All 7 Platforms)
Files to modify:
app/Services/AdvertisingTrackingService.php   — Add Google/Snapchat/Pinterest/Twitter/LinkedIn CAPI dispatch
app/Services/GoogleAdsService.php             — Add sendServerEvent() method
app/Services/SnapchatService.php              — Add sendServerEvent() method
app/Services/PinterestService.php             — Add sendServerEvent() method
app/Services/TwitterService.php               — Add sendServerEvent() method
app/Services/LinkedInService.php              — Add sendServerEvent() method
config/services.php                           — Add platform API endpoint URLs
Implementation spec:
// In AdvertisingTrackingService::trackEvent() — currently only checks:
if ($fbCapiEnabled) { $this->sendFacebookCapiEvent(...) }
if ($ttCapiEnabled) { $this->sendTikTokCapiEvent(...) }

// ADD after TikTok block:
if ($googleCapiEnabled) { $this->googleAdsService->sendConversion(...); }
if ($snapCapiEnabled) { $this->snapchatService->sendEvent(...); }
if ($pinCapiEnabled) { $this->pinterestService->sendEvent(...); }
if ($twCapiEnabled) { $this->twitterService->sendEvent(...); }
if ($liCapiEnabled) { $this->linkedinService->sendEvent(...); }
Each platform service needs:
- sendConversion(array $eventData): array — maps standard event → platform-specific format
- SHA256 user data hashing (email, phone, name)
- _gclid capture for Google, _scid for Snapchat, click ID forwarding
- Response logging to capi_event_logs with platform field
- Retry logic (3 attempts, 1s delay)
- 10s timeout
New ENV variables:
GOOGLE_CAPI_ENABLED=true
SNAPCHAT_CAPI_ENABLED=true
PINTEREST_CAPI_ENABLED=true
TWITTER_CAPI_ENABLED=true
LINKEDIN_CAPI_ENABLED=true
Module 1B: Fix MetaLeadHub (Stub → Full)
Current: modules/CustomAdmin/Http/Controllers/MetaLeadHubController.php — all methods return empty collections or hardcoded success.
Files to create/modify:
modules/Meta/Services/LeadSyncService.php              — CREATE: Real Facebook Graph API sync
modules/Meta/Services/WhatsAppService.php               — CREATE: WhatsApp Cloud API integration
modules/Meta/Services/LeadScoringService.php            — CREATE: ML-based lead scoring
app/Jobs/SyncFacebookLeads.php                          — CREATE: Queued job
app/Jobs/SendWhatsAppFollowUp.php                       — CREATE: Queued job
database/migrations/xxxx_add_lead_scoring_fields.php    — CREATE
resources/views/admin/meta-marketing/leads-hub.blade.php — REWRITE
Lead Hub features:
1. Sync from Facebook — Use existing leads_retrieval scope, fetch leads via Graph API /{page_id}/leadgen_forms → /{form_id}/leads
2. Lead scoring — Score 0-100 based on: data completeness, lead age, form type, previous conversion patterns
3. Auto-segmentation — Hot (score>70), Warm (40-70), Cold (<40)
4. WhatsApp follow-ups — Via WhatsApp Cloud API /{phone_number_id}/messages, Arabic templates
5. Bulk messaging — Select leads → send WhatsApp/SMS campaign
6. Conversion pipeline — Lead → Contact → Booking, track full funnel
7. Export — Excel with custom column selection
8. Lead source — Track which ad campaign/ad set generated each lead
Database additions to meta_leads:
ALTER TABLE meta_leads ADD COLUMN lead_score INT DEFAULT 0;
ALTER TABLE meta_leads ADD COLUMN segment ENUM('hot','warm','cold') DEFAULT 'cold';
ALTER TABLE meta_leads ADD COLUMN followed_up_at TIMESTAMP NULL;
ALTER TABLE meta_leads ADD COLUMN follow_up_status ENUM('pending','sent','replied','converted') DEFAULT 'pending';
ALTER TABLE meta_leads ADD COLUMN converted_to_booking_id BIGINT UNSIGNED NULL;
ALTER TABLE meta_leads ADD COLUMN campaign_id VARCHAR(100) NULL;
ALTER TABLE meta_leads ADD COLUMN adset_id VARCHAR(100) NULL;
ALTER TABLE meta_leads ADD COLUMN ad_id VARCHAR(100) NULL;
Module 1C: Fix SEO Management
Current: app/Http/Controllers/Admin/SeoController.php — all methods redirect with "not available".
Files to create/modify:
app/Services/SeoService.php                              — CREATE
app/Services/Seo/ArabicKeywordResearchService.php        — CREATE
app/Services/Seo/SchemaMarkupGenerator.php               — CREATE
app/Models/SeoData.php                                   — CREATE (or use existing if exists)
database/migrations/xxxx_create_seo_data_table.php       — CREATE
resources/views/admin/seo/index.blade.php                — REWRITE
resources/views/admin/seo/edit.blade.php                 — REWRITE
SEO features:
1. Auto meta generation — Pull title, description, OG tags from page content using AI
2. Bulk generation — One-click generate SEO for all pages/blog posts/services
3. Schema markup — Auto-generate JSON-LD for: WebSite, LocalBusiness, Service, FAQ, Article, Product, BreadcrumbList
4. Arabic keyword research — Find high-volume Arabic beauty/wellness keywords
5. Content gap analysis — Compare against competitor keywords
6. Page speed monitoring — Lighthouse scores per page
7. Sitemap generation — Auto-regenerate XML sitemap
8. Robots.txt management — UI-based editor
9. Broken link checker — Scan site for 404s
Database: seo_data table:
CREATE TABLE seo_data (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_type VARCHAR(50) NOT NULL,      -- 'home','blog','service','booking','page'
    page_id BIGINT UNSIGNED NULL,
    title_ar VARCHAR(200) NULL,
    title_en VARCHAR(200) NULL,
    description_ar TEXT NULL,
    description_en TEXT NULL,
    keywords_ar TEXT NULL,
    keywords_en TEXT NULL,
    og_title VARCHAR(200) NULL,
    og_description TEXT NULL,
    og_image VARCHAR(500) NULL,
    canonical_url VARCHAR(500) NULL,
    schema_type VARCHAR(50) NULL,        -- 'WebSite','LocalBusiness',etc
    schema_markup JSON NULL,
    priority DECIMAL(2,1) DEFAULT 0.5,
    change_frequency ENUM('always','hourly','daily','weekly','monthly','yearly','never') DEFAULT 'weekly',
    is_auto_generated TINYINT(1) DEFAULT 0,
    last_generated_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
4. Phase 2: CAPI & Compliance — Days 8-14
Goal: Complete tracking infrastructure. Hardened compliance. Real-time visibility.
Module 2A: Enhanced CAPI Diagnostics 2.0
Files to modify:
app/Http/Controllers/Admin/CapiDiagnosticsController.php  — Add per-platform breakdowns
app/Services/MetaReportingService.php                     — Add CAPI quality metrics
resources/views/admin/meta-marketing/diagnostics.blade.php — Add platform comparison charts
New CAPI diagnostics views:
- Platform comparison radar — Success rate, latency, event volume per platform
- Enhanced matching rate — % of events with hashed user data vs anonymous
- Deduplication effectiveness — % events deduplicated per platform
- Error pattern detection — Auto-detect recurring error patterns
- CAPI Health Score — Composite score 0-100 per platform
- Alert rules — Configurable thresholds per platform, per event type
Module 2B: AI Compliance Guardian 2.0
Files to create/modify:
app/Services/Sanitization/PlatformPolicyChecker.php     — CREATE: Per-platform policy check
app/Services/Sanitization/ImageModerationService.php    — CREATE: Image content check
app/Services/Sanitization/AudienceRestrictionFilter.php — CREATE: Age/gender/location compliance
app/Console/Commands/PreFlightCreativeCheck.php         — CREATE
Features:
1. Pre-publish creative check — Before sending creative to any platform API, run full compliance pipeline
2. Platform-specific rules — Each platform has different policies (Meta ≠ TikTok ≠ Google)
3. Image moderation — Check creative images for prohibited content
4. Audience restriction validation — Ensure age/gender/location targeting is compliant
5. Compliance score per creative — 0-100 score, block if < threshold
6. Auto-fix suggestions — "Replace word 'علاج' with 'عناية'" suggestions
Module 2C: Real-Time Conversion Wall
Files to create:
app/Events/NewConversion.php                              — CREATE: Laravel event
app/Events/CapiEventReceived.php                          — CREATE: Laravel event
app/Listeners/BroadcastConversion.php                     — CREATE
app/Listeners/UpdateConversionWall.php                    — CREATE
resources/views/admin/partials/conversion-wall.blade.php  — CREATE
public/js/admin/conversion-wall.js                        — CREATE
routes/channels.php                                       — MODIFY (private channel auth)
Features:
1. WebSocket-powered live ticker — Real-time conversion events via Laravel Reverb
2. Conversion cards — Each conversion shows: service name, amount, source platform, city, time
3. Sound effects — Audio alert for conversions > threshold amount
4. Geo-map — Pin drops on Palestine map for each conversion
5. Platform comparison — Side-by-side live counters per platform
6. Daily goal tracker — Progress bar toward daily revenue target
7. Top performer leaderboard — Best performing campaigns/adsets this hour
5. Phase 3: Intelligence Core — Days 15-28
Goal: AI-powered creative generation, predictive analytics, audience intelligence.
Module 3A: AI Creative Copilot
Files to create/modify:
app/Services/AI/CreativeGeneratorService.php              — CREATE
app/Services/AI/CreativeScorerService.php                 — CREATE
app/Services/AI/ArabicPromptOptimizerService.php          — CREATE
app/Http/Controllers/Admin/AiCreativeController.php       — CREATE
database/migrations/xxxx_create_creative_variations_table.php — CREATE
resources/views/admin/ai-creative/index.blade.php         — CREATE
resources/views/admin/ai-creative/generate.blade.php      — CREATE
routes/admin.php                                          — ADD routes
API:
// POST /admin/ai-creative/generate
// Body: { platform, objective, audience_description, product_name, tone, num_variations }
// Response: { variations: [{ headline, primary_text, description, cta, compliance_score, quality_score }] }
Creative Variation Schema:
CREATE TABLE creative_variations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    creative_id BIGINT UNSIGNED NULL,             -- FK to meta_ad_creatives
    platform VARCHAR(20) NOT NULL,
    headline VARCHAR(255) NOT NULL,
    primary_text TEXT NULL,
    description TEXT NULL,
    cta VARCHAR(50) NULL,
    language VARCHAR(10) DEFAULT 'ar',
    quality_score INT DEFAULT 0,                   -- 0-100 AI prediction
    compliance_score INT DEFAULT 0,                -- 0-100 compliance check
    engagement_prediction DECIMAL(5,2) NULL,       -- predicted CTR
    llm_provider VARCHAR(20) NULL,                 -- openai|claude|llama
    llm_model VARCHAR(50) NULL,                    -- gpt-4o|claude-3.5-sonnet|llama3
    prompt_tokens INT DEFAULT 0,
    completion_tokens INT DEFAULT 0,
    is_published TINYINT(1) DEFAULT 0,
    published_at TIMESTAMP NULL,
    performance_score DECIMAL(5,2) NULL,           -- actual performance after running
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
Features:
1. "Generate & Test" workflow — 1 click generates 10 variations → publishes to ad platform → monitors performance
2. Tone selector — Professional, Friendly, Luxury, Urgent, Educational, Emotional
3. Arabic prompt optimization — Specializes in Arabic ad copy with cultural nuance
4. Creative DNA library — Learns which copy patterns work best for your audience
5. Competitor-inspired suggestions — Analyze top competitor copy patterns, suggest similar
6. A/B test automator — Split test headlines/descriptions automatically, declare winner
Module 3B: Intelligent Audience Builder
Files to create/modify:
app/Services/Audience/AudienceBuilderService.php         — CREATE
app/Services/Audience/LookalikeGeneratorService.php       — CREATE
app/Services/Audience/AudienceFatigueDetector.php         — CREATE
app/Services/Audience/InterestExpansionService.php        — CREATE
app/Http/Controllers/Admin/AudienceController.php         — CREATE
database/migrations/xxxx_create_custom_audiences_table.php — CREATE
database/migrations/xxxx_create_audience_insights_table.php — CREATE
resources/views/admin/audiences/index.blade.php           — CREATE
resources/views/admin/audiences/create.blade.php          — CREATE
Database:
CREATE TABLE custom_audiences (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    platform VARCHAR(20) NOT NULL,                -- meta|tiktok|google|snapchat|pinterest
    platform_audience_id VARCHAR(100) NULL,       -- ID on the platform
    source_type ENUM('lookalike','custom','website','engagement','lead_form','capi'),
    seed_source VARCHAR(100) NULL,                -- 'purchasers_30d', 'high_value_leads', etc
    audience_size INT DEFAULT 0,
    lookalike_ratio DECIMAL(2,1) NULL,            -- 1-10% for lookalike
    country VARCHAR(50) DEFAULT 'PS',
    status ENUM('draft','syncing','ready','error','fatigued') DEFAULT 'draft',
    fatigue_score INT DEFAULT 0,                   -- 0-100, higher = more fatigued
    last_synced_at TIMESTAMP NULL,
    performance_ctr DECIMAL(5,2) NULL,
    performance_cpa DECIMAL(10,2) NULL,
    performance_roas DECIMAL(5,2) NULL,
    metadata JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE audience_insights (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    audience_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    impressions INT DEFAULT 0,
    clicks INT DEFAULT 0,
    ctr DECIMAL(5,2) NULL,
    spend DECIMAL(10,2) DEFAULT 0,
    conversions INT DEFAULT 0,
    cpa DECIMAL(10,2) NULL,
    roas DECIMAL(5,2) NULL,
    fatigue_indicator DECIMAL(3,1) NULL,          -- declining trend indicator
    FOREIGN KEY (audience_id) REFERENCES custom_audiences(id) ON DELETE CASCADE
);
Features:
1. Lookalike generation — From CAPI purchasers, website visitors, lead form completions → upload to Meta/TikTok/Google/Snapchat/Pinterest
2. Audience fatigue detection — Monitors CTR/CPA trends, alerts when audience needs refresh
3. Interest expansion — ML finds adjacent interests from converter profiles
4. Audience overlap analysis — Prevents bidding against yourself across ad sets
5. Seed audience builder — Create seeds from: high-LTV customers, recent converters, abandoned cart, page engagers
6. Size estimation — Predict audience size before creation
7. One-click push — Push audience to multiple platforms simultaneously
Module 3C: Predictive Campaign Simulator
Files to create/modify:
app/Services/Predictive/CampaignSimulatorService.php      — CREATE
app/Services/Predictive/PerformancePredictor.php          — CREATE
app/Services/Predictive/BudgetOptimizer.php               — CREATE
ml-service/campaign_predictor.py                          — CREATE (new ML model)
ml-service/train_campaign_model.py                        — CREATE
app/Http/Controllers/Admin/CampaignSimulatorController.php — CREATE
resources/views/admin/simulator/index.blade.php           — CREATE
resources/views/admin/simulator/results.blade.php         — CREATE
ML Model (Python):
# ml-service/campaign_predictor.py
# Features: platform, objective, budget, audience_size, industry, 
#            creative_count, historical_ctr, historical_cpa, day_of_week,
#            season, country, bid_strategy, placement_types
# Target: predicted_ctr, predicted_cpa, predicted_roas, risk_score
# Model: XGBoost Regressor (multi-output)
Features:
1. Pre-launch prediction — Enter campaign parameters → get predicted CTR, CPC, CPA, ROAS
2. Risk score — 0-100 (red/yellow/green) based on historical similar campaign outcomes
3. "What-if" simulator — Sliders for budget, audience, creative count → see predicted changes
4. Optimal budget calculator — Given target CPA, calculates optimal daily budget
5. Best day/time to launch — Based on historical conversion patterns
6. Post-launch tracking — Compare prediction vs actual, feed back into model
7. Confidence interval — Show range (pessimistic/expected/optimistic)
6. Phase 4: Automation Engines — Days 29-42
Goal: Automate everything. Budget optimization, creative rotation, retargeting.
Module 4A: Cross-Platform Budget Optimizer
Files to create/modify:
app/Services/Optimization/BudgetAllocationService.php     — CREATE
app/Services/Optimization/DiminishingReturnsCalculator.php — CREATE
app/Services/Optimization/DaypartingService.php           — CREATE
app/Console/Commands/OptimizeBudgetAllocation.php         — CREATE
app/Jobs/RebalanceBudget.php                              — CREATE
resources/views/admin/optimizer/index.blade.php           — CREATE
resources/views/admin/optimizer/waterfall.blade.php       — CREATE
Algorithm:
1. Every 30 minutes, fetch ROAS per platform (last 24h)
2. Calculate marginal ROAS (diminishing returns curve per platform)
3. If platform A's marginal ROAS > platform B's marginal ROAS → shift budget
4. Respect min/max budget per platform (configurable)
5. Dayparting: allocate more during peak conversion hours (historical data)
6. Apply platform-specific constraints (Meta min $5/day, TikTok min $20/day, etc.)
7. Generate recommendation report → auto-execute if enabled
Features:
1. Auto mode — Automatically rebalance budget every 30 minutes
2. Semi-auto mode — Generate recommendations, admin approves via one click
3. Manual mode — Visualization only, admin decides
4. "Budget Waterfall" chart — Shows money flow from source to platform to campaign to conversion
5. Diminishing returns visualization — Curve per platform showing spend vs ROAS
6. Dayparting heatmap — Shows best hours per platform, auto-adjusts
7. Platform health factored in — Don't send budget to unhealthy platforms
8. Emergency stop — One-click pause all spending across all platforms
Module 4B: Dynamic Creative Optimization (DCO)
Files to create/modify:
app/Services/Creative/CreativeRotationService.php         — CREATE
app/Services/Creative/PerformanceMonitorService.php       — CREATE
app/Services/Creative/ABTestEngine.php                    — CREATE
app/Console/Commands/RotateCreatives.php                  — CREATE
app/Console/Commands/AnalyzeABTests.php                   — CREATE
resources/views/admin/dco/index.blade.php                 — CREATE
resources/views/admin/dco/tests.blade.php                 — CREATE
Features:
1. Auto-rotation — Every N hours, replace underperforming creative with best variant
2. Performance thresholds — CTR < 0.5% → auto-pause creative; CTR > 2% → promote
3. A/B test engine — Set up multivariate tests (headline × image × CTA)
4. Statistical significance — Bayesian calculator, declares winner at 95% confidence
5. Creative lifetime value — Track how long a creative performs before fatigue
6. Fatigue detection — CTR declining 3+ days → flag for refresh
7. Creative DNA analysis — What elements (colors, words, layouts) drive performance
8. Auto-generate refreshes — When fatigue detected, auto-generate new variations via AI
Module 4C: Smart Auto-Pause 3.0 (All Platforms)
Files to modify:
app/Services/AdAutoPauseService.php                        — REWRITE: extend to 7 platforms
app/Services/AdSpendMonitorService.php                     — REWRITE: add non-Meta platforms
app/Console/Commands/AdsHealthCheck.php                    — REWRITE: check all platforms
app/Console/Commands/AdsSpendMonitor.php                   — REWRITE: monitor all platforms
Platform-specific pause logic via each service:
FacebookGraphService::pauseCampaign($campaignId)
GoogleAdsService::pauseCampaign($campaignId)       — ADD
SnapchatService::pauseCampaign($campaignId)         — ADD
PinterestService::pauseCampaign($campaignId)        — ADD
TwitterService::pauseCampaign($campaignId)          — ADD
LinkedInService::pauseCampaign($campaignId)         — ADD
// TikTok campaign management needs to be built first
Features:
1. Unified health dashboard — All 7 platforms' health scores in one view
2. ML auto-tuning — Thresholds adjust based on historical patterns (no more manual config)
3. Anomaly correlation — "Meta CPA spike + Google CTR drop → likely audience issue"
4. Pre-pause warning — Alert 15 minutes before auto-pause (configurable)
5. Rollback capability — One-click undo last auto-pause
6. Weekly health report — Auto-emailed summary of all platform health scores
7. Phase 5: Unified Command — Days 43-56
Goal: One dashboard to rule them all. Custom reports. AI insights.
Module 5A: Unified Command Center
Files to create/modify:
app/Services/Reporting/UnifiedMetricsService.php          — CREATE
app/Services/Reporting/CustomReportBuilder.php            — CREATE
app/Services/Reporting/ScheduledReportService.php          — CREATE
app/Services/Reporting/AiInsightGenerator.php             — CREATE
app/Http/Controllers/Admin/CommandCenterController.php    — CREATE
app/Jobs/GenerateScheduledReport.php                      — CREATE
resources/views/admin/command-center/index.blade.php      — CREATE
resources/views/admin/command-center/reports.blade.php    — CREATE
public/js/admin/command-center.js                         — CREATE
Dashboard widgets (drag-and-drop):
 1. Cross-platform spend — Stacked bar: spend per platform, per day
 2. Unified ROAS — Weighted ROAS across all platforms
 3. Conversion funnel — Impression→Click→ViewContent→ATC→Purchase per platform
 4. Geo-heatmap — Conversion density map
 5. Platform health scores — 7 gauges with trend arrows
 6. Active campaign count — Per platform, per status
 7. Top campaigns — Sortable table (ROAS, CPA, Conversions)
 8. Real-time conversion ticker — From Conversion Wall module
 9. Alerts panel — Grouped by severity, platform
10. AI insight cards — "Your TikTok CPA improved 22% this week because..."
11. Revenue vs Spend — Dual-axis chart
12. Hourly performance — Heatmap: hour × platform = ROAS
Custom report builder:
- Drag-and-drop widget placement
- Save report configurations
- Schedule: daily at 9am, weekly Monday, monthly 1st
- Delivery: email PDF, Slack message, Telegram, in-app notification
- Export: PDF, Excel, CSV, JSON
- Shareable report links
Module 5B: Attribution 3.0
Files to create/modify:
app/Services/Attribution/MarkovAttributionService.php     — CREATE
app/Services/Attribution/ShapleyAttributionService.php    — CREATE
app/Services/Attribution/CrossDeviceResolver.php          — CREATE
app/Services/Attribution/AttributionComparisonService.php — CREATE
app/Http/Controllers/Admin/AttributionController.php      — CREATE
resources/views/admin/attribution/index.blade.php         — CREATE
resources/views/admin/attribution/compare.blade.php       — CREATE
Attribution models:
1. First Click — Already implemented
2. Last Click — Already implemented
3. Linear — Already implemented
4. Position-Based — Already implemented
5. Time Decay — Already implemented
6. Markov Chain — Data-driven, removes channels sequentially to measure impact
7. Shapley Value — Game theory approach, fair credit distribution
Features:
1. Model comparison — Side-by-side revenue attribution per channel under each model
2. Channel value shift — "Google gets 15% credit in Last Click, 28% in Markov"
3. Assisted conversions — Which channels assist but don't close
4. Conversion path analysis — Most common touch sequences visualized as Sankey diagram
5. Cross-device stitching — Match users via login, UUID, fingerprint
6. Time-to-conversion — Average days from first touch to purchase
7. Touch count distribution — How many touches before conversion (histogram)
Module 5C: SEO Intelligence Engine
(Already covered in Phase 1C — this phase completes any remaining features)
8. Phase 6: Growth Acceleration — Days 57-70
Goal: Competitor intelligence, retargeting, affiliate scaling, ML service upgrade.
Module 6A: Competitor Intelligence
Files to create/modify:
app/Services/Competitor/AdLibraryScraperService.php       — CREATE
app/Services/Competitor/CompetitorTrackerService.php       — CREATE
app/Services/Competitor/MarketPositioningService.php       — CREATE
app/Jobs/ScrapeCompetitorAds.php                           — CREATE
app/Console/Commands/CompetitorReport.php                  — CREATE
database/migrations/xxxx_create_competitors_table.php      — CREATE
database/migrations/xxxx_create_competitor_ads_table.php   — CREATE
resources/views/admin/competitors/index.blade.php          — CREATE
Database:
CREATE TABLE competitors (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    facebook_page_id VARCHAR(100) NULL,
    website VARCHAR(500) NULL,
    instagram_handle VARCHAR(100) NULL,
    tiktok_handle VARCHAR(100) NULL,
    notes TEXT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE competitor_ads (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    competitor_id BIGINT UNSIGNED NOT NULL,
    platform VARCHAR(20) NOT NULL,
    platform_ad_id VARCHAR(100) NULL,
    ad_snapshot_url VARCHAR(500) NULL,
    headline TEXT NULL,
    primary_text TEXT NULL,
    cta VARCHAR(50) NULL,
    image_urls JSON NULL,
    video_url VARCHAR(500) NULL,
    landing_page_url VARCHAR(500) NULL,
    estimated_spend_low DECIMAL(10,2) NULL,
    estimated_spend_high DECIMAL(10,2) NULL,
    estimated_impressions_low INT NULL,
    estimated_impressions_high INT NULL,
    active_days INT DEFAULT 0,
    first_seen_at TIMESTAMP NULL,
    last_seen_at TIMESTAMP NULL,
    is_active TINYINT(1) DEFAULT 1,
    ad_theme VARCHAR(100) NULL,               -- AI-classified theme
    sentiment VARCHAR(20) NULL,               -- positive|neutral|urgent|emotional
    creative_elements JSON NULL,              -- { has_video, has_carousel, color_palette, etc }
    FOREIGN KEY (competitor_id) REFERENCES competitors(id) ON DELETE CASCADE
);
Features:
1. Facebook Ad Library scraping — Auto-fetch competitor active ads
2. Creative theme analysis — AI classifies competitor ad themes
3. Spend estimation — Estimated budget ranges from Meta's Ad Library data
4. Competitive landscape — Visual map of who's advertising what
5. Gap analysis — "Your competitors are advertising X, but you're not"
6. New campaign alerts — "Competitor X just launched 5 new ads"
7. Weekly competitive report — Auto-generated PDF
Module 6B: Retargeting Intelligence
Files to create/modify:
app/Services/Retargeting/RetargetingSegmentService.php    — CREATE
app/Services/Retargeting/CartAbandonmentService.php        — CREATE
app/Services/Retargeting/SequentialRetargetingService.php  — CREATE
app/Services/Retargeting/FrequencyCappingService.php       — CREATE
app/Jobs/UpdateRetargetingSegments.php                     — CREATE
database/migrations/xxxx_create_retargeting_segments_table.php — CREATE
resources/views/admin/retargeting/index.blade.php          — CREATE
Segments (auto-created):
1. Cart abandoners — Started booking, didn't complete → retarget within 1h, 24h, 72h
2. Service browsers — Viewed specific service 3+ times → retarget with that service
3. High-intent visitors — Visited booking page, stayed 2+ min → retarget
4. Past customers — Booked before, no booking in 30 days → win-back offer
5. Blog readers — Read 3+ articles → retarget with related service
6. Coupon hunters — Used coupon code before → retarget with new coupon
7. VIP customers — LTV > threshold → exclusive offers
Sequential retargeting:
- Touch 1 (1h after abandon): "Reminder" message
- Touch 2 (24h after): "Limited time offer" + coupon
- Touch 3 (72h after): "Last chance" + urgency
- Max 3 touches → move to dormant segment
Module 6C: Affiliate System 2.0
Files to create/modify:
app/Services/Affiliate/AffiliateMultiTierService.php      — CREATE
app/Services/Affiliate/AffiliatePerformanceService.php    — CREATE
app/Jobs/CalculateAffiliateCommissions.php                — CREATE
database/migrations/xxxx_add_affiliate_tiers.php          — CREATE
resources/views/admin/affiliates/performance.blade.php    — CREATE
resources/views/frontend/affiliate/leaderboard.blade.php  — CREATE
Features:
1. Multi-tier commissions — Affiliate earns on their referrals AND their sub-affiliates
2. Performance-based tiers — Silver (5%), Gold (7%), Platinum (10%), Diamond (12%)
3. Leaderboard — Public page showing top affiliates (gamification)
4. Marketing assets — Downloadable banners, swipe copy, video templates
5. Affiliate link generator — Create deep links to specific services/campaigns
6. Performance dashboard — Clicks, conversions, EPC, commission earned
7. Automated payouts — Monthly auto-calculation + notification
9. Complete Database Schema (New Tables)
-- ============================================================
-- PHASE 1: Foundation
-- ============================================================

-- SEO Data (1C)
CREATE TABLE seo_data (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_type VARCHAR(50) NOT NULL,
    page_id BIGINT UNSIGNED NULL,
    title_ar VARCHAR(200) NULL,
    title_en VARCHAR(200) NULL,
    description_ar TEXT NULL,
    description_en TEXT NULL,
    keywords_ar TEXT NULL,
    keywords_en TEXT NULL,
    og_title VARCHAR(200) NULL,
    og_description TEXT NULL,
    og_image VARCHAR(500) NULL,
    canonical_url VARCHAR(500) NULL,
    schema_type VARCHAR(50) NULL,
    schema_markup JSON NULL,
    priority DECIMAL(2,1) DEFAULT 0.5,
    change_frequency ENUM('always','hourly','daily','weekly','monthly','yearly','never') DEFAULT 'weekly',
    is_auto_generated TINYINT(1) DEFAULT 0,
    last_generated_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_page (page_type, page_id)
);

-- Lead Scoring additions to meta_leads
ALTER TABLE meta_leads ADD COLUMN IF NOT EXISTS lead_score INT DEFAULT 0;
ALTER TABLE meta_leads ADD COLUMN IF NOT EXISTS segment ENUM('hot','warm','cold') DEFAULT 'cold';
ALTER TABLE meta_leads ADD COLUMN IF NOT EXISTS followed_up_at TIMESTAMP NULL;
ALTER TABLE meta_leads ADD COLUMN IF NOT EXISTS follow_up_status ENUM('pending','sent','replied','converted') DEFAULT 'pending';
ALTER TABLE meta_leads ADD COLUMN IF NOT EXISTS converted_to_booking_id BIGINT UNSIGNED NULL;
ALTER TABLE meta_leads ADD COLUMN IF NOT EXISTS ad_campaign_id VARCHAR(100) NULL;
ALTER TABLE meta_leads ADD COLUMN IF NOT EXISTS ad_adset_id VARCHAR(100) NULL;
ALTER TABLE meta_leads ADD COLUMN IF NOT EXISTS ad_id VARCHAR(100) NULL;

-- ============================================================
-- PHASE 2: CAPI & Compliance
-- ============================================================

-- Platform CAPI event logs (extend existing capi_event_logs)
ALTER TABLE capi_event_logs ADD COLUMN IF NOT EXISTS platform VARCHAR(20) DEFAULT 'facebook';
ALTER TABLE capi_event_logs ADD COLUMN IF NOT EXISTS enhanced_match_rate DECIMAL(3,1) NULL;
ALTER TABLE capi_event_logs ADD COLUMN IF NOT EXISTS deduplicated TINYINT(1) DEFAULT 0;
ALTER TABLE capi_event_logs ADD COLUMN IF NOT EXISTS retry_count INT DEFAULT 0;
CREATE INDEX IF NOT EXISTS idx_capi_platform_status ON capi_event_logs(platform, success, created_at);

-- Conversion wall events
CREATE TABLE conversion_wall_events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_type VARCHAR(50) NOT NULL,
    platform VARCHAR(20) NULL,
    booking_id BIGINT UNSIGNED NULL,
    service_name VARCHAR(255) NULL,
    amount DECIMAL(10,2) NULL,
    city VARCHAR(100) NULL,
    source VARCHAR(100) NULL,
    metadata JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- PHASE 3: Intelligence Core
-- ============================================================

-- AI Creative Variations (3A)
CREATE TABLE creative_variations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    creative_id BIGINT UNSIGNED NULL,
    platform VARCHAR(20) NOT NULL,
    headline VARCHAR(255) NOT NULL,
    primary_text TEXT NULL,
    description TEXT NULL,
    cta VARCHAR(50) NULL,
    language VARCHAR(10) DEFAULT 'ar',
    quality_score INT DEFAULT 0,
    compliance_score INT DEFAULT 0,
    engagement_prediction DECIMAL(5,2) NULL,
    llm_provider VARCHAR(20) NULL,
    llm_model VARCHAR(50) NULL,
    prompt_tokens INT DEFAULT 0,
    completion_tokens INT DEFAULT 0,
    is_published TINYINT(1) DEFAULT 0,
    published_at TIMESTAMP NULL,
    performance_score DECIMAL(5,2) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Custom Audiences (3B)
CREATE TABLE custom_audiences (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    platform VARCHAR(20) NOT NULL,
    platform_audience_id VARCHAR(100) NULL,
    source_type ENUM('lookalike','custom','website','engagement','lead_form','capi'),
    seed_source VARCHAR(100) NULL,
    audience_size INT DEFAULT 0,
    lookalike_ratio DECIMAL(2,1) NULL,
    country VARCHAR(50) DEFAULT 'PS',
    status ENUM('draft','syncing','ready','error','fatigued') DEFAULT 'draft',
    fatigue_score INT DEFAULT 0,
    last_synced_at TIMESTAMP NULL,
    performance_ctr DECIMAL(5,2) NULL,
    performance_cpa DECIMAL(10,2) NULL,
    performance_roas DECIMAL(5,2) NULL,
    metadata JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Audience Insights (3B)
CREATE TABLE audience_insights (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    audience_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    impressions INT DEFAULT 0,
    clicks INT DEFAULT 0,
    ctr DECIMAL(5,2) NULL,
    spend DECIMAL(10,2) DEFAULT 0,
    conversions INT DEFAULT 0,
    cpa DECIMAL(10,2) NULL,
    roas DECIMAL(5,2) NULL,
    fatigue_indicator DECIMAL(3,1) NULL,
    FOREIGN KEY (audience_id) REFERENCES custom_audiences(id) ON DELETE CASCADE,
    UNIQUE KEY uk_audience_date (audience_id, date)
);

-- Campaign Predictions (3C)
CREATE TABLE campaign_predictions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    campaign_id BIGINT UNSIGNED NULL,
    platform VARCHAR(20) NOT NULL,
    predicted_ctr DECIMAL(5,2) NULL,
    predicted_cpc DECIMAL(10,4) NULL,
    predicted_cpa DECIMAL(10,2) NULL,
    predicted_roas DECIMAL(5,2) NULL,
    risk_score INT DEFAULT 0,
    confidence_low DECIMAL(5,2) NULL,
    confidence_high DECIMAL(5,2) NULL,
    model_version VARCHAR(20) NULL,
    input_params JSON NULL,
    actual_ctr DECIMAL(5,2) NULL,
    actual_cpa DECIMAL(10,2) NULL,
    actual_roas DECIMAL(5,2) NULL,
    prediction_error_pct DECIMAL(5,2) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================================
-- PHASE 4: Automation Engines
-- ============================================================

-- Budget Allocation Log (4A)
CREATE TABLE budget_allocation_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    platform VARCHAR(20) NOT NULL,
    campaign_id BIGINT UNSIGNED NULL,
    previous_budget DECIMAL(10,2) NULL,
    new_budget DECIMAL(10,2) NULL,
    change_reason VARCHAR(255) NULL,
    roas_before DECIMAL(5,2) NULL,
    roas_after DECIMAL(5,2) NULL,
    mode ENUM('auto','semi-auto','manual') DEFAULT 'manual',
    executed_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- A/B Tests (4B)
CREATE TABLE ab_tests (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    platform VARCHAR(20) NOT NULL,
    campaign_id BIGINT UNSIGNED NULL,
    test_type ENUM('headline','primary_text','description','cta','image','multivariate'),
    variant_a_id BIGINT UNSIGNED NULL,
    variant_b_id BIGINT UNSIGNED NULL,
    status ENUM('running','completed','stopped') DEFAULT 'running',
    confidence_level DECIMAL(3,1) NULL,
    winner_variant ENUM('a','b','inconclusive') NULL,
    started_at TIMESTAMP NULL,
    ended_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE ab_test_results (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ab_test_id BIGINT UNSIGNED NOT NULL,
    variant ENUM('a','b') NOT NULL,
    date DATE NOT NULL,
    impressions INT DEFAULT 0,
    clicks INT DEFAULT 0,
    ctr DECIMAL(5,2) NULL,
    spend DECIMAL(10,2) DEFAULT 0,
    conversions INT DEFAULT 0,
    cpa DECIMAL(10,2) NULL,
    roas DECIMAL(5,2) NULL,
    FOREIGN KEY (ab_test_id) REFERENCES ab_tests(id) ON DELETE CASCADE
);

-- Creative Performance Log (4B)
CREATE TABLE creative_performance_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    creative_id BIGINT UNSIGNED NOT NULL,
    date DATE NOT NULL,
    impressions INT DEFAULT 0,
    clicks INT DEFAULT 0,
    ctr DECIMAL(5,2) NULL,
    conversions INT DEFAULT 0,
    spend DECIMAL(10,2) DEFAULT 0,
    roas DECIMAL(5,2) NULL,
    fatigue_score INT DEFAULT 0,
    is_rotated TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_creative_date (creative_id, date)
);

-- ============================================================
-- PHASE 5: Unified Command
-- ============================================================

-- Custom Reports (5A)
CREATE TABLE custom_reports (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    widgets JSON NOT NULL,
    layout JSON NULL,
    schedule_cron VARCHAR(100) NULL,
    delivery_email VARCHAR(255) NULL,
    delivery_slack VARCHAR(255) NULL,
    delivery_telegram VARCHAR(255) NULL,
    is_active TINYINT(1) DEFAULT 1,
    last_generated_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Attribution Paths (5B)
CREATE TABLE attribution_paths (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    identity_uuid VARCHAR(100) NOT NULL,
    booking_id BIGINT UNSIGNED NULL,
    touch_sequence JSON NOT NULL,                 -- array of {channel, timestamp, event}
    touch_count INT DEFAULT 0,
    first_touch_channel VARCHAR(50) NULL,
    last_touch_channel VARCHAR(50) NULL,
    conversion_time_hours DECIMAL(8,1) NULL,
    attribution_model_results JSON NULL,          -- {first_click: {channel: value}, markov: {...}, etc}
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_identity (identity_uuid),
    INDEX idx_booking (booking_id)
);

-- ============================================================
-- PHASE 6: Growth Acceleration
-- ============================================================

-- Competitors (6A)
CREATE TABLE competitors (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    facebook_page_id VARCHAR(100) NULL,
    website VARCHAR(500) NULL,
    instagram_handle VARCHAR(100) NULL,
    tiktok_handle VARCHAR(100) NULL,
    notes TEXT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE competitor_ads (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    competitor_id BIGINT UNSIGNED NOT NULL,
    platform VARCHAR(20) NOT NULL,
    platform_ad_id VARCHAR(100) NULL,
    headline TEXT NULL,
    primary_text TEXT NULL,
    image_urls JSON NULL,
    landing_page_url VARCHAR(500) NULL,
    estimated_spend_low DECIMAL(10,2) NULL,
    estimated_spend_high DECIMAL(10,2) NULL,
    active_days INT DEFAULT 0,
    first_seen_at TIMESTAMP NULL,
    last_seen_at TIMESTAMP NULL,
    is_active TINYINT(1) DEFAULT 1,
    ad_theme VARCHAR(100) NULL,
    FOREIGN KEY (competitor_id) REFERENCES competitors(id) ON DELETE CASCADE
);

-- Retargeting Segments (6B)
CREATE TABLE retargeting_segments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    segment_type ENUM('cart_abandoner','service_browser','high_intent','past_customer','blog_reader','coupon_hunter','vip'),
    user_count INT DEFAULT 0,
    platform_audience_ids JSON NULL,
    last_synced_at TIMESTAMP NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
10. Complete Route Registry (New Routes)
// routes/admin.php — ADD these route groups

// ============================================================
// AI Creative Copilot (Phase 3A)
// ============================================================
Route::prefix('ai-creative')->group(function () {
    Route::get('/', [AiCreativeController::class, 'index'])->name('admin.ai-creative.index');
    Route::get('/generate', [AiCreativeController::class, 'generateForm'])->name('admin.ai-creative.generate-form');
    Route::post('/generate', [AiCreativeController::class, 'generate'])->name('admin.ai-creative.generate');
    Route::post('/publish/{variation}', [AiCreativeController::class, 'publish'])->name('admin.ai-creative.publish');
    Route::post('/batch-publish', [AiCreativeController::class, 'batchPublish'])->name('admin.ai-creative.batch-publish');
    Route::delete('/{variation}', [AiCreativeController::class, 'destroy'])->name('admin.ai-creative.destroy');
    Route::get('/performance/{variation}', [AiCreativeController::class, 'performance'])->name('admin.ai-creative.performance');
});

// ============================================================
// Audiences (Phase 3B)
// ============================================================
Route::prefix('audiences')->group(function () {
    Route::get('/', [AudienceController::class, 'index'])->name('admin.audiences.index');
    Route::get('/create', [AudienceController::class, 'create'])->name('admin.audiences.create');
    Route::post('/', [AudienceController::class, 'store'])->name('admin.audiences.store');
    Route::post('/{audience}/sync', [AudienceController::class, 'sync'])->name('admin.audiences.sync');
    Route::post('/{audience}/push-to-platform', [AudienceController::class, 'pushToPlatform'])->name('admin.audiences.push');
    Route::get('/{audience}/insights', [AudienceController::class, 'insights'])->name('admin.audiences.insights');
    Route::delete('/{audience}', [AudienceController::class, 'destroy'])->name('admin.audiences.destroy');
    Route::get('/overlap-analysis', [AudienceController::class, 'overlapAnalysis'])->name('admin.audiences.overlap');
});

// ============================================================
// Campaign Simulator (Phase 3C)
// ============================================================
Route::prefix('simulator')->group(function () {
    Route::get('/', [CampaignSimulatorController::class, 'index'])->name('admin.simulator.index');
    Route::post('/predict', [CampaignSimulatorController::class, 'predict'])->name('admin.simulator.predict');
    Route::post('/what-if', [CampaignSimulatorController::class, 'whatIf'])->name('admin.simulator.what-if');
    Route::post('/optimal-budget', [CampaignSimulatorController::class, 'optimalBudget'])->name('admin.simulator.optimal-budget');
    Route::get('/history', [CampaignSimulatorController::class, 'history'])->name('admin.simulator.history');
});

// ============================================================
// Budget Optimizer (Phase 4A)
// ============================================================
Route::prefix('optimizer')->group(function () {
    Route::get('/', [OptimizerController::class, 'index'])->name('admin.optimizer.index');
    Route::post('/recommend', [OptimizerController::class, 'recommend'])->name('admin.optimizer.recommend');
    Route::post('/execute', [OptimizerController::class, 'execute'])->name('admin.optimizer.execute');
    Route::post('/settings', [OptimizerController::class, 'updateSettings'])->name('admin.optimizer.settings');
    Route::get('/waterfall', [OptimizerController::class, 'waterfall'])->name('admin.optimizer.waterfall');
    Route::post('/emergency-stop', [OptimizerController::class, 'emergencyStop'])->name('admin.optimizer.emergency-stop');
    Route::get('/history', [OptimizerController::class, 'history'])->name('admin.optimizer.history');
});

// ============================================================
// DCO - Dynamic Creative Optimization (Phase 4B)
// ============================================================
Route::prefix('dco')->group(function () {
    Route::get('/', [DcoController::class, 'index'])->name('admin.dco.index');
    Route::get('/tests', [DcoController::class, 'tests'])->name('admin.dco.tests');
    Route::post('/tests', [DcoController::class, 'createTest'])->name('admin.dco.create-test');
    Route::get('/tests/{test}', [DcoController::class, 'showTest'])->name('admin.dco.show-test');
    Route::post('/tests/{test}/declare-winner', [DcoController::class, 'declareWinner'])->name('admin.dco.declare-winner');
    Route::post('/rotate', [DcoController::class, 'rotateCreatives'])->name('admin.dco.rotate');
    Route::get('/fatigue-report', [DcoController::class, 'fatigueReport'])->name('admin.dco.fatigue');
});

// ============================================================
// Unified Command Center (Phase 5A)
// ============================================================
Route::prefix('command-center')->group(function () {
    Route::get('/', [CommandCenterController::class, 'index'])->name('admin.command-center.index');
    Route::get('/data', [CommandCenterController::class, 'data'])->name('admin.command-center.data');
    Route::get('/reports', [CommandCenterController::class, 'reports'])->name('admin.command-center.reports');
    Route::post('/reports', [CommandCenterController::class, 'saveReport'])->name('admin.command-center.save-report');
    Route::get('/reports/{report}', [CommandCenterController::class, 'showReport'])->name('admin.command-center.show-report');
    Route::delete('/reports/{report}', [CommandCenterController::class, 'deleteReport'])->name('admin.command-center.delete-report');
    Route::post('/reports/{report}/generate', [CommandCenterController::class, 'generateReport'])->name('admin.command-center.generate-report');
    Route::get('/insights', [CommandCenterController::class, 'insights'])->name('admin.command-center.insights');
});

// ============================================================
// Attribution (Phase 5B)
// ============================================================
Route::prefix('attribution')->group(function () {
    Route::get('/', [AttributionController::class, 'index'])->name('admin.attribution.index');
    Route::get('/compare', [AttributionController::class, 'compare'])->name('admin.attribution.compare');
    Route::get('/paths', [AttributionController::class, 'paths'])->name('admin.attribution.paths');
    Route::get('/paths/{path}', [AttributionController::class, 'showPath'])->name('admin.attribution.show-path');
    Route::get('/data', [AttributionController::class, 'data'])->name('admin.attribution.data');
});

// ============================================================
// Competitors (Phase 6A)
// ============================================================
Route::prefix('competitors')->group(function () {
    Route::get('/', [CompetitorController::class, 'index'])->name('admin.competitors.index');
    Route::post('/', [CompetitorController::class, 'store'])->name('admin.competitors.store');
    Route::get('/{competitor}', [CompetitorController::class, 'show'])->name('admin.competitors.show');
    Route::put('/{competitor}', [CompetitorController::class, 'update'])->name('admin.competitors.update');
    Route::delete('/{competitor}', [CompetitorController::class, 'destroy'])->name('admin.competitors.destroy');
    Route::post('/{competitor}/scrape', [CompetitorController::class, 'scrape'])->name('admin.competitors.scrape');
    Route::get('/report/weekly', [CompetitorController::class, 'weeklyReport'])->name('admin.competitors.weekly-report');
});

// ============================================================
// Retargeting (Phase 6B)
// ============================================================
Route::prefix('retargeting')->group(function () {
    Route::get('/', [RetargetingController::class, 'index'])->name('admin.retargeting.index');
    Route::post('/segments', [RetargetingController::class, 'createSegment'])->name('admin.retargeting.create-segment');
    Route::post('/segments/{segment}/sync', [RetargetingController::class, 'syncSegment'])->name('admin.retargeting.sync');
    Route::get('/segments/{segment}', [RetargetingController::class, 'showSegment'])->name('admin.retargeting.show');
    Route::delete('/segments/{segment}', [RetargetingController::class, 'destroy'])->name('admin.retargeting.destroy');
    Route::get('/cart-abandonment', [RetargetingController::class, 'cartAbandonment'])->name('admin.retargeting.cart');
});

// ============================================================
// Conversion Wall API (Phase 2C)
// ============================================================
Route::prefix('conversion-wall')->group(function () {
    Route::get('/events', [ConversionWallController::class, 'recent'])->name('admin.conversion-wall.recent');
    Route::get('/stats', [ConversionWallController::class, 'stats'])->name('admin.conversion-wall.stats');
});
11. New Controllers (Complete List)
app/Http/Controllers/Admin/AiCreativeController.php         — AI creative generation
app/Http/Controllers/Admin/AudienceController.php           — Audience management
app/Http/Controllers/Admin/CampaignSimulatorController.php  — Campaign simulator
app/Http/Controllers/Admin/OptimizerController.php          — Budget optimizer
app/Http/Controllers/Admin/DcoController.php                — DCO engine
app/Http/Controllers/Admin/CommandCenterController.php      — Unified command
app/Http/Controllers/Admin/AttributionController.php        — Attribution
app/Http/Controllers/Admin/CompetitorController.php         — Competitor intelligence
app/Http/Controllers/Admin/RetargetingController.php        — Retargeting
app/Http/Controllers/Admin/ConversionWallController.php     — Conversion wall
12. New Services (Complete List)
app/Services/AI/CreativeGeneratorService.php                — AI creative generation
app/Services/AI/CreativeScorerService.php                   — Creative quality scoring
app/Services/AI/ArabicPromptOptimizerService.php            — Arabic prompt tuning

app/Services/Audience/AudienceBuilderService.php            — Audience builder
app/Services/Audience/LookalikeGeneratorService.php         — Lookalike generation
app/Services/Audience/AudienceFatigueDetector.php           — Fatigue detection
app/Services/Audience/InterestExpansionService.php          — Interest expansion

app/Services/Predictive/CampaignSimulatorService.php        — Campaign ML predictions
app/Services/Predictive/PerformancePredictor.php            — Performance ML
app/Services/Predictive/BudgetOptimizer.php                 — Budget ML optimization

app/Services/Optimization/BudgetAllocationService.php       — Budget allocation
app/Services/Optimization/DiminishingReturnsCalculator.php  — Returns curves
app/Services/Optimization/DaypartingService.php             — Dayparting logic

app/Services/Creative/CreativeRotationService.php           — Creative rotation
app/Services/Creative/PerformanceMonitorService.php         — Creative monitoring
app/Services/Creative/ABTestEngine.php                      — A/B test logic

app/Services/Reporting/UnifiedMetricsService.php            — Unified metrics
app/Services/Reporting/CustomReportBuilder.php              — Report builder
app/Services/Reporting/ScheduledReportService.php           — Scheduled delivery
app/Services/Reporting/AiInsightGenerator.php               — AI insights

app/Services/Attribution/MarkovAttributionService.php       — Markov model
app/Services/Attribution/ShapleyAttributionService.php      — Shapley model
app/Services/Attribution/CrossDeviceResolver.php            — Cross-device
app/Services/Attribution/AttributionComparisonService.php   — Model comparison

app/Services/Competitor/AdLibraryScraperService.php         — Ad Library scraper
app/Services/Competitor/CompetitorTrackerService.php         — Competitor tracking
app/Services/Competitor/MarketPositioningService.php        — Positioning

app/Services/Retargeting/RetargetingSegmentService.php      — Segments
app/Services/Retargeting/CartAbandonmentService.php         — Cart recovery
app/Services/Retargeting/SequentialRetargetingService.php   — Sequences
app/Services/Retargeting/FrequencyCappingService.php        — Frequency caps

app/Services/SeoService.php                                 — SEO engine
app/Services/Seo/ArabicKeywordResearchService.php           — Arabic keywords
app/Services/Seo/SchemaMarkupGenerator.php                  — Schema generator

app/Services/Affiliate/AffiliateMultiTierService.php        — Multi-tier
app/Services/Affiliate/AffiliatePerformanceService.php      — Performance

app/Services/Sanitization/PlatformPolicyChecker.php         — Platform policies
app/Services/Sanitization/ImageModerationService.php        — Image check
app/Services/Sanitization/AudienceRestrictionFilter.php     — Audience check
13. New Console Commands
app/Console/Commands/OptimizeBudgetAllocation.php           — Run budget optimizer
app/Console/Commands/RotateCreatives.php                    — Rotate creatives
app/Console/Commands/AnalyzeABTests.php                     — Check A/B test results
app/Console/Commands/ScrapeCompetitorAds.php                 — Scrape competitors
app/Console/Commands/UpdateRetargetingSegments.php          — Update segments
app/Console/Commands/GenerateScheduledReports.php           — Generate reports
app/Console/Commands/SyncFacebookLeads.php                  — Sync leads
app/Console/Commands/PreFlightCreativeCheck.php             — Check creatives
app/Console/Commands/CompetitorReport.php                   — Weekly report
app/Console/Commands/TrainCampaignModel.php                 — ML training
Kernel schedule additions:
// app/Console/Kernel.php
protected function schedule(Schedule $schedule): void
{
    // Existing...
    
    // Every 30 min: Optimize budget allocation
    $schedule->command('ads:optimize-budget')->everyThirtyMinutes();
    
    // Every 2 hours: Rotate underperforming creatives
    $schedule->command('ads:rotate-creatives')->everyTwoHours();
    
    // Every 6 hours: Check A/B test results
    $schedule->command('ads:analyze-ab-tests')->everySixHours();
    
    // Daily: Scrape competitor ads
    $schedule->command('competitors:scrape')->dailyAt('06:00');
    
    // Every 3 hours: Update retargeting segments
    $schedule->command('retargeting:update-segments')->everyThreeHours();
    
    // Hourly: Sync Facebook leads
    $schedule->command('leads:sync-facebook')->hourly();
    
    // Daily: Generate scheduled reports
    $schedule->command('reports:generate-scheduled')->dailyAt('08:00');
    
    // Weekly: Competitor report
    $schedule->command('competitors:report')->weekly()->mondays()->at('09:00');
    
    // Weekly: Train campaign prediction model
    $schedule->command('ml:train-campaign-model')->weekly()->sundays()->at('03:00');
}
14. New Blade Views (Complete List)
resources/views/admin/ai-creative/
├── index.blade.php              — Creative library with history
├── generate.blade.php           — Generation form (platform, objective, tone, etc.)
└── partials/
    └── variation-card.blade.php — Single variation display card

resources/views/admin/audiences/
├── index.blade.php              — Audience list
├── create.blade.php             — Create audience form
├── insights.blade.php           — Audience performance insights
└── overlap.blade.php            — Overlap analysis chart

resources/views/admin/simulator/
├── index.blade.php              — Simulator form + results
└── history.blade.php            — Past predictions vs actuals

resources/views/admin/optimizer/
├── index.blade.php              — Budget optimizer dashboard
├── waterfall.blade.php          — Budget waterfall visualization
└── history.blade.php            — Allocation change history

resources/views/admin/dco/
├── index.blade.php              — DCO dashboard
├── tests.blade.php              — A/B test list
└── test-detail.blade.php        — Single test detail

resources/views/admin/command-center/
├── index.blade.php              — Unified dashboard
├── reports.blade.php            — Custom reports list
└── report-detail.blade.php      — Single report view

resources/views/admin/attribution/
├── index.blade.php              — Attribution overview
├── compare.blade.php            — Model comparison tool
└── paths.blade.php              — Conversion path analysis

resources/views/admin/competitors/
├── index.blade.php              — Competitor list
├── show.blade.php               — Single competitor detail
└── weekly-report.blade.php      — Auto-generated report

resources/views/admin/retargeting/
├── index.blade.php              — Retargeting dashboard
├── segments/
│   ├── create.blade.php         — Create segment
│   └── show.blade.php           — Segment detail
└── cart-abandonment.blade.php   — Cart abandonment stats

resources/views/admin/partials/
└── conversion-wall.blade.php    — Real-time conversion ticker
15. ML Service Additions
New Python module: ml-service/campaign_predictor.py
# XGBoost multi-output regression model
# Features: platform, objective, budget, audience_size, creative_count, 
#            day_of_week, season, country, bid_strategy, placement_types
# Targets: predicted_ctr, predicted_cpa, predicted_roas, risk_score
# Endpoints:
#   POST /predict-campaign     — Single prediction
#   POST /train-campaign-model — Retrain with latest data
#   GET  /model-info           — Model version, accuracy, feature importance
New Python module: ml-service/lead_scorer.py
# Random Forest classifier
# Features: form_type, data_completeness, lead_age_hours, 
#            time_of_day, day_of_week, source_campaign_type
# Target: conversion_probability (0-1)
# Endpoints:
#   POST /score-lead     — Score single lead
#   POST /score-batch    — Score batch of leads
16. Testing Matrix
Module	Unit Tests	Feature Tests
CAPI Completion	7 platform services	Full event flow per platform
MetaLeadHub	LeadSyncService, LeadScoringService	Sync flow, WhatsApp send
SEO Engine	SeoService, SchemaGenerator	Generate per page type
AI Creative	CreativeGenerator, CreativeScorer	Generate + compliance check
Audiences	AudienceBuilder, LookalikeGenerator	Create + sync audience
Campaign Simulator	Predictor, BudgetOptimizer	Predict → compare with actual
Budget Optimizer	BudgetAllocationService	Recommend → execute flow
DCO Engine	RotationService, ABTestEngine	Test lifecycle
Command Center	UnifiedMetricsService	Widget data endpoints
Attribution	MarkovService, ShapleyService	Model comparison
Competitors	ScraperService, TrackerService	Scrape → store → alert
Retargeting	SegmentService, AbandonmentService	Segment creation → sync
17. Timeline & Resource Plan
Week 1-2  ████████ Phase 1: Foundation
          ├── CAPI Completion (all 7 platforms)
          ├── MetaLeadHub (stub → full)
          └── SEO Engine (stub → full)

Week 3-4  ████████ Phase 2: CAPI & Compliance
          ├── Enhanced CAPI Diagnostics 2.0
          ├── AI Compliance Guardian 2.0
          └── Real-Time Conversion Wall

Week 5-6  ████████ Phase 3: Intelligence Core (Part 1)
          ├── AI Creative Copilot
          └── Intelligent Audience Builder

Week 7-8  ████████ Phase 3: Intelligence Core (Part 2)
          └── Predictive Campaign Simulator

Week 9-10 ████████ Phase 4: Automation Engines
          ├── Cross-Platform Budget Optimizer
          ├── DCO Engine
          └── Smart Auto-Pause 3.0

Week 11-12 ███████ Phase 5: Unified Command
          ├── Unified Command Center
          └── Attribution 3.0

Week 13-14 ███████ Phase 6: Growth Acceleration
          ├── Competitor Intelligence
          ├── Retargeting Intelligence
          └── Affiliate System 2.0
18. Deployment & Monitoring
Per-phase deployment:
1. git checkout -b phase/X-module-name
2. Implement → test → PR to main
3. GitHub Actions auto-deploys to samahcare.shop
4. Monitor via Laravel Pulse + Horizon
5. Rollback: git revert + auto-deploy
Monitoring additions:
- All new scheduled commands log to storage/logs/
- CAPI failure alerts via Slack/Telegram (existing AlertNotifier)
- Budget optimizer changes logged to budget_allocation_logs
- A/B test completions trigger notification
- Competitor ad changes trigger notification
- ML model accuracy tracked in campaign_predictions.prediction_error_pct
Summary: Total Deliverables
Category	Count
New Controllers	10
New Services	36
New Models	8
New Migrations	18
New Console Commands	10
New Blade Views	34
New Routes	80+
New ML Models	2
Modified Files	15+
Total Files	~130
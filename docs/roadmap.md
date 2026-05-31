# Samah Care — Meta + Google Professional Development Roadmap

## Scope: Facebook/Meta + Google Ads Only

---

## Phase 1: Foundation (Days 1-7)

### 1A: Google Ads CAPI Wiring
- [ ] Wire Google CAPI into `AdvertisingTrackingService::trackEvent()`
- [ ] Add `sendGoogleCAPI()` method to `AdvertisingTrackingService`
- [ ] Add enhanced matching (hashed email, phone, name) for Google
- [ ] Forward `_gclid` for Google conversion attribution
- [ ] Log all Google CAPI events to `capi_event_logs`

### 1B: MetaLeadHub Complete Rebuild
- [ ] Rebuild `MetaLeadHubController` with real Facebook Graph API sync
- [ ] Create `LeadSyncService` with real lead fetching from Facebook
- [ ] Add lead scoring (ML-based, 0-100)
- [ ] Add auto-segmentation (hot/warm/cold)
- [ ] Add WhatsApp Cloud API integration for follow-ups
- [ ] Build leads-hub blade view with real data
- [ ] Add lead-to-booking conversion pipeline

### 1C: SEO Management (Complete Stub)
- [ ] Build `SeoService` with auto meta generation
- [ ] Build schema markup generator for LocalBusiness, Service, FAQ, Article
- [ ] Arabic keyword research tool
- [ ] Bulk SEO generation for all pages

---

## Phase 2: Campaign Management (Days 8-14)

### 2A: Google Ads Campaign Management
- [ ] Create `GoogleAdsCampaignService` with full CRUD
- [ ] Create `GoogleAdsController` for admin UI
- [ ] Campaign CRUD (create, update, pause, resume, delete)
- [ ] Ad Group management
- [ ] Keyword management with match types
- [ ] Responsive search ad creation
- [ ] Campaign insights fetching
- [ ] Budget and bid management
- [ ] Admin blade views for Google Ads dashboard

### 2B: Meta Creative Variations
- [ ] Create `CreativeVariationService` for AI-generated ad copy
- [ ] Generate headlines, primary text, descriptions in Arabic
- [ ] Pre-flight compliance check before publishing
- [ ] Quality scoring for generated variations
- [ ] One-click publish to Meta ad platform
- [ ] Performance tracking per variation

---

## Phase 3: Intelligence Core (Days 15-28)

### 3A: AI Creative Copilot (Meta + Google)
- [ ] Create `CreativeGeneratorService` using OpenAI/Claude/Llama
- [ ] Generate 10+ creative variations per request
- [ ] Arabic-optimized prompts for beauty/wellness industry
- [ ] Platform-specific formatting (Meta vs Google character limits)
- [ ] A/B test automation
- [ ] Creative DNA library (learns what works)

### 3B: Audience Builder (Meta + Google)
- [ ] Create `AudienceBuilderService`
- [ ] Lookalike audiences from CAPI conversion data
- [ ] Custom audience creation and sync to platforms
- [ ] Audience fatigue detection
- [ ] Interest expansion from converter profiles
- [ ] Audience overlap analysis

### 3C: Predictive Campaign Simulator
- [ ] Create `CampaignSimulatorService` with ML predictions
- [ ] Predict CTR, CPC, CPA, ROAS before launch
- [ ] Risk score for campaigns
- [ ] Optimal budget calculator
- [ ] Post-launch prediction vs actual tracking

---

## Phase 4: Automation (Days 29-42)

### 4A: Cross-Platform Budget Optimizer (Meta + Google)
- [ ] Create `BudgetAllocationService`
- [ ] AI-driven budget distribution based on ROAS
- [ ] Diminishing returns calculation per platform
- [ ] Dayparting optimization
- [ ] Auto-recommend or auto-execute budget shifts

### 4B: DCO Engine (Meta + Google)
- [ ] Create `CreativeRotationService`
- [ ] Auto-rotate creatives based on performance
- [ ] A/B test engine with statistical significance
- [ ] Creative fatigue detection
- [ ] Auto-pause underperformers, promote winners

### 4C: Smart Auto-Pause (Meta + Google)
- [ ] Extend `AdAutoPauseService` to Google Ads
- [ ] Health-based pause for both platforms
- [ ] Spend anomaly detection for Google
- [ ] Unified health dashboard

---

## Phase 5: Unified Command (Days 43-56)

### 5A: Unified Command Center
- [ ] Single dashboard for Meta + Google metrics
- [ ] Custom report builder
- [ ] Scheduled report delivery
- [ ] AI-powered insights

### 5B: Attribution 3.0
- [ ] Markov chain attribution model
- [ ] Shapley value attribution
- [ ] Cross-device identity resolution
- [ ] Model comparison tool

---

## Phase 6: Growth (Days 57-70)

### 6A: Retargeting Intelligence
- [ ] Cart abandonment retargeting
- [ ] Sequential retargeting (3-touch)
- [ ] Frequency capping across platforms

### 6B: Competitor Intelligence
- [ ] Facebook Ad Library scraping
- [ ] Competitor ad tracking
- [ ] Weekly competitive report

---

## Database Migrations Needed

### Phase 1
- `seo_data` table
- Extend `meta_leads` with scoring fields
- Extend `capi_event_logs` with platform index

### Phase 2
- `google_campaigns` table
- `google_ad_groups` table
- `google_keywords` table
- `google_ads` table

### Phase 3
- `creative_variations` table
- `custom_audiences` table
- `audience_insights` table
- `campaign_predictions` table

### Phase 4
- `budget_allocation_logs` table
- `ab_tests` table
- `ab_test_results` table
- `creative_performance_logs` table

### Phase 5
- `attribution_paths` table
- `custom_reports` table

---

## New Services to Create

### Meta Services
- `app/Services/Meta/LeadSyncService.php` (rewrite)
- `app/Services/Meta/WhatsAppService.php`
- `app/Services/Meta/LeadScoringService.php`
- `app/Services/Meta/CreativeManagementService.php`

### Google Services
- `app/Services/Google/CampaignService.php`
- `app/Services/Google/AdGroupService.php`
- `app/Services/Google/KeywordService.php`
- `app/Services/Google/ResponsiveAdService.php`
- `app/Services/Google/InsightsService.php`

### Shared Services
- `app/Services/AI/CreativeGeneratorService.php`
- `app/Services/Audience/AudienceBuilderService.php`
- `app/Services/Predictive/CampaignSimulatorService.php`
- `app/Services/Optimization/BudgetAllocationService.php`
- `app/Services/Creative/CreativeRotationService.php`
- `app/Services/Reporting/UnifiedMetricsService.php`
- `app/Services/Attribution/MarkovAttributionService.php`
- `app/Services/Retargeting/RetargetingSegmentService.php`

---

## New Controllers

- `app/Http/Controllers/Admin/GoogleAdsController.php`
- `app/Http/Controllers/Admin/AiCreativeController.php`
- `app/Http/Controllers/Admin/AudienceController.php`
- `app/Http/Controllers/Admin/CampaignSimulatorController.php`
- `app/Http/Controllers/Admin/OptimizerController.php`
- `app/Http/Controllers/Admin/DcoController.php`
- `app/Http/Controllers/Admin/CommandCenterController.php`
- `app/Http/Controllers/Admin/AttributionController.php`
- `app/Http/Controllers/Admin/RetargetingController.php`

---

## New Blade Views

```
resources/views/admin/google-ads/
├── index.blade.php
├── campaigns.blade.php
├── campaign-create.blade.php
├── ad-groups.blade.php
├── keywords.blade.php
├── responsive-ads.blade.php
└── insights.blade.php

resources/views/admin/ai-creative/
├── index.blade.php
├── generate.blade.php
└── variations.blade.php

resources/views/admin/audiences/
├── index.blade.php
├── create.blade.php
└── insights.blade.php

resources/views/admin/simulator/
├── index.blade.php
└── results.blade.php

resources/views/admin/optimizer/
├── index.blade.php
└── waterfall.blade.php

resources/views/admin/dco/
├── index.blade.php
└── tests.blade.php

resources/views/admin/command-center/
├── index.blade.php
└── reports.blade.php

resources/views/admin/attribution/
├── index.blade.php
└── compare.blade.php

resources/views/admin/retargeting/
├── index.blade.php
└── segments.blade.php
```

---

## KPIs Target

| Metric | Current | Target |
|--------|---------|--------|
| ROAS | ~2-3x | 5-7x |
| CPA | Baseline | -40% |
| Attribution Rate | ~30% | 85%+ |
| Creative Production | Manual | AI 10x |
| Platform Coverage | Meta only | Meta + Google |

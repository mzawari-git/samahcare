<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\SeoController;
use Modules\CustomAdmin\Http\Controllers\MarketingTrackingController;
use App\Http\Controllers\Admin\TriggerWordController;
use App\Http\Controllers\Admin\AiComplianceController;
use App\Http\Controllers\Admin\PredictiveController;
use App\Http\Controllers\Admin\ReviewerIpController;
use Modules\CustomAdmin\Http\Controllers\MetaAdsController;
use Modules\CustomAdmin\Http\Controllers\MetaLeadHubController;
use App\Http\Controllers\Admin\AffiliateController as AdminAffiliateController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\RoasController;
use App\Http\Controllers\Admin\CapiDiagnosticsController;
use App\Http\Controllers\Admin\AdAlertController;
use App\Http\Controllers\Admin\GoogleAdsController;
use App\Http\Controllers\Admin\AiCreativeController;
use App\Http\Controllers\Admin\AudienceController;
use App\Http\Controllers\Admin\MetaToolsController;

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    // SEO Management
    Route::get('/seo', [SeoController::class, 'index'])->name('admin.seo.index');
    Route::get('/seo/{id}/edit', [SeoController::class, 'edit'])->name('admin.seo.edit');
    Route::post('/seo/{id}/auto', [SeoController::class, 'autoGenerate'])->name('admin.seo.auto');
    Route::post('/seo/auto-all', [SeoController::class, 'autoGenerateAll'])->name('admin.seo.auto-all');
    Route::post('/seo/ai-all', [SeoController::class, 'aiGenerateAll'])->name('admin.seo.ai-all');
    Route::put('/seo/{id}', [SeoController::class, 'update'])->name('admin.seo.update');
    Route::get('/seo/{id}/schema', [SeoController::class, 'schema'])->name('admin.seo.schema');

    // Meta Hub - الصفحة الرئيسية الموحدة لكل أدوات Meta
    Route::get('/meta-hub', function () {
        return view('admin.meta-hub');
    })->name('admin.meta-hub.index');

    Route::get('/meta-marketing', [MarketingTrackingController::class, 'metaMarketingDashboard'])->name('admin.meta-marketing.index');
    Route::post('/meta-marketing/import-page', [MarketingTrackingController::class, 'importPage'])->name('admin.meta-marketing.import-page');
    Route::post('/meta-marketing/search-page', [MarketingTrackingController::class, 'searchPage'])->name('admin.meta-marketing.search-page');
    Route::get('/meta-marketing/conversations', [MarketingTrackingController::class, 'conversations'])->name('admin.meta-marketing.conversations');
    Route::get('/meta-marketing/conversations/{id}', [MarketingTrackingController::class, 'conversationShow'])->name('admin.meta-marketing.conversation-show');
    Route::post('/meta-marketing/conversations/{id}/reply', [MarketingTrackingController::class, 'replyConversation'])->name('admin.meta-marketing.reply');
    Route::get('/meta-marketing/leads', [MarketingTrackingController::class, 'leads'])->name('admin.meta-marketing.leads');
    Route::get('/meta-marketing/audiences', [MarketingTrackingController::class, 'audiences'])->name('admin.meta-marketing.audiences');
    Route::get('/meta-marketing/webhooks', [MarketingTrackingController::class, 'webhookLogs'])->name('admin.meta-marketing.webhooks');
    Route::get('/meta-marketing/stats', [MarketingTrackingController::class, 'dashboardStats'])->name('admin.meta-marketing.stats');
    Route::get('/meta-marketing/diagnostics', [CapiDiagnosticsController::class, 'index'])->name('admin.diagnostics.index');
    Route::get('/meta-marketing/diagnostics/data', [CapiDiagnosticsController::class, 'data'])->name('admin.diagnostics.data');
    Route::delete('/meta-marketing/pages/{id}', [MarketingTrackingController::class, 'deletePage'])->name('admin.meta-marketing.delete-page');

    // Ads Management
    Route::get('/ads', [MetaAdsController::class, 'dashboard'])->name('admin.ads.dashboard');
    Route::post('/ads/accounts/connect', [MetaAdsController::class, 'connectAccount'])->name('admin.ads.connect-account');
    Route::delete('/ads/accounts/{id}', [MetaAdsController::class, 'deleteAdAccount'])->name('admin.ads.delete-account');

    // Campaigns
    Route::post('/ads/campaigns', [MetaAdsController::class, 'createCampaign'])->name('admin.ads.create-campaign');
    Route::put('/ads/campaigns/{id}', [MetaAdsController::class, 'updateCampaign'])->name('admin.ads.update-campaign');
    Route::post('/ads/campaigns/{id}/toggle', [MetaAdsController::class, 'toggleCampaign'])->name('admin.ads.toggle-campaign');
    Route::delete('/ads/campaigns/{id}', [MetaAdsController::class, 'deleteCampaign'])->name('admin.ads.delete-campaign');
    Route::post('/ads/campaigns/{id}/insights', [MetaAdsController::class, 'getCampaignInsights'])->name('admin.ads.campaign-insights');
    Route::get('/ads/campaigns/{id}/adsets', [MetaAdsController::class, 'getCampaignAdSets'])->name('admin.ads.campaign-adsets');
    Route::post('/ads/campaigns/{id}/duplicate', [MetaAdsController::class, 'duplicateCampaign'])->name('admin.ads.duplicate-campaign');

    // Ad Sets
    Route::post('/ads/adsets', [MetaAdsController::class, 'createAdSet'])->name('admin.ads.create-adset');
    Route::put('/ads/adsets/{id}', [MetaAdsController::class, 'updateAdSet'])->name('admin.ads.update-adset');
    Route::post('/ads/adsets/{id}/toggle', [MetaAdsController::class, 'toggleAdSet'])->name('admin.ads.toggle-adset');
    Route::get('/ads/adsets/{id}/ads', [MetaAdsController::class, 'getAdSetAds'])->name('admin.ads.adset-ads');
    Route::post('/ads/adsets/{id}/insights', [MetaAdsController::class, 'getAdSetInsights'])->name('admin.ads.adset-insights');

    // Creatives
    Route::post('/ads/creatives', [MetaAdsController::class, 'uploadCreative'])->name('admin.ads.upload-creative');
    Route::post('/ads/creatives/save', [MetaAdsController::class, 'saveCreative'])->name('admin.ads.save-creative');
    Route::put('/ads/creatives/{id}', [MetaAdsController::class, 'updateCreative'])->name('admin.ads.update-creative');
    Route::delete('/ads/creatives/{id}', [MetaAdsController::class, 'deleteCreative'])->name('admin.ads.delete-creative');
    Route::get('/ads/creatives/list', [MetaAdsController::class, 'getCreatives'])->name('admin.ads.list-creatives');

    // Ads
    Route::post('/ads/create', [MetaAdsController::class, 'createAd'])->name('admin.ads.create-ad');
    Route::put('/ads/{id}', [MetaAdsController::class, 'updateAd'])->name('admin.ads.update-ad');
    Route::post('/ads/{id}/toggle', [MetaAdsController::class, 'toggleAd'])->name('admin.ads.toggle-ad');
    Route::post('/ads/{id}/insights', [MetaAdsController::class, 'getAdInsights'])->name('admin.ads.ad-insights');

    // Bulk
    Route::post('/ads/insights/refresh', [MetaAdsController::class, 'refreshInsights'])->name('admin.ads.refresh-insights');
    Route::post('/ads/sync', [MetaAdsController::class, 'syncCampaigns'])->name('admin.ads.sync');

    // Google Ads Management
    Route::get('/google-ads', [GoogleAdsController::class, 'index'])->name('admin.google-ads.index');
    Route::post('/google-ads', [GoogleAdsController::class, 'store'])->name('admin.google-ads.store');
    Route::put('/google-ads/{campaignId}', [GoogleAdsController::class, 'update'])->name('admin.google-ads.update');
    Route::post('/google-ads/{campaignId}/toggle', [GoogleAdsController::class, 'toggle'])->name('admin.google-ads.toggle');
    Route::delete('/google-ads/{campaignId}', [GoogleAdsController::class, 'destroy'])->name('admin.google-ads.destroy');
    Route::get('/google-ads/{campaignId}/insights', [GoogleAdsController::class, 'insights'])->name('admin.google-ads.insights');
    Route::get('/google-ads/{campaignId}/ad-groups', [GoogleAdsController::class, 'adGroups'])->name('admin.google-ads.ad-groups');
    Route::post('/google-ads/{campaignId}/ad-groups', [GoogleAdsController::class, 'createAdGroup'])->name('admin.google-ads.create-ad-group');
    Route::get('/google-ads/ad-groups/{adGroupId}/keywords', [GoogleAdsController::class, 'keywords'])->name('admin.google-ads.keywords');
    Route::post('/google-ads/ad-groups/{adGroupId}/keywords', [GoogleAdsController::class, 'addKeyword'])->name('admin.google-ads.add-keyword');
    Route::post('/google-ads/ad-groups/{adGroupId}/responsive-ad', [GoogleAdsController::class, 'createResponsiveAd'])->name('admin.google-ads.create-responsive-ad');
    Route::get('/google-ads/test-connection', [GoogleAdsController::class, 'testConnection'])->name('admin.google-ads.test-connection');
    Route::get('/google-ads/metrics', [GoogleAdsController::class, 'getMetrics'])->name('admin.google-ads.metrics');

    // OAuth Connect for all social platforms
    Route::get('/oauth/{platform}/redirect', [\App\Http\Controllers\Admin\SocialAuthController::class, 'redirect'])
        ->name('admin.oauth.redirect');
    Route::get('/oauth/{platform}/callback', [\App\Http\Controllers\Admin\SocialAuthController::class, 'callback'])
        ->name('admin.oauth.callback');
    Route::delete('/oauth/{platform}/disconnect', [\App\Http\Controllers\Admin\SocialAuthController::class, 'disconnect'])
        ->name('admin.oauth.disconnect');

    // Hero Slides
    Route::get('/hero-slides', [HeroSlideController::class, 'index'])->name('admin.hero-slides.index');
    Route::get('/hero-slides/create', [HeroSlideController::class, 'create'])->name('admin.hero-slides.create');
    Route::post('/hero-slides', [HeroSlideController::class, 'store'])->name('admin.hero-slides.store');
    Route::get('/hero-slides/{heroSlide}/edit', [HeroSlideController::class, 'edit'])->name('admin.hero-slides.edit');
    Route::put('/hero-slides/{heroSlide}', [HeroSlideController::class, 'update'])->name('admin.hero-slides.update');
    Route::delete('/hero-slides/{heroSlide}', [HeroSlideController::class, 'destroy'])->name('admin.hero-slides.destroy');
    Route::patch('/hero-slides/{heroSlide}/toggle', [HeroSlideController::class, 'toggle'])->name('admin.hero-slides.toggle');

    // Services
    Route::get('/services', [ServiceController::class, 'index'])->name('admin.services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('admin.services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('admin.services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('admin.services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');
    Route::post('/services/{service}/toggle', [ServiceController::class, 'toggle'])->name('admin.services.toggle');

    // Bookings
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('admin.bookings.show');
    Route::post('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('admin.bookings.update-status');
    Route::delete('/bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('admin.bookings.destroy');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Coupons
    Route::get('/coupons', [CouponController::class, 'index'])->name('admin.coupons.index');
    Route::get('/coupons/create', [CouponController::class, 'create'])->name('admin.coupons.create');
    Route::post('/coupons', [CouponController::class, 'store'])->name('admin.coupons.store');
    Route::get('/coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('admin.coupons.edit');
    Route::put('/coupons/{coupon}', [CouponController::class, 'update'])->name('admin.coupons.update');
    Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])->name('admin.coupons.destroy');

    // Contacts
    Route::get('/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
    Route::get('/contacts/{contactMessage}', [ContactController::class, 'show'])->name('admin.contacts.show');
    Route::patch('/contacts/{contactMessage}/read', [ContactController::class, 'markRead'])->name('admin.contacts.mark-read');
    Route::delete('/contacts/{contactMessage}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('admin.analytics.index');
    Route::get('/analytics/export', [AnalyticsController::class, 'export'])->name('admin.analytics.export');

    // Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity-logs.index');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('admin.notifications.unread');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.mark-read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.read-all');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('admin.notifications.destroy');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
    Route::delete('/settings/delete-logo', [SettingController::class, 'deleteLogo'])->name('admin.settings.delete-logo');

    // Redirect old marketing URL to new account-configuration
    Route::get('/marketing', fn() => redirect()->route('admin.account-configuration.index'));
    Route::get('/marketing/{any}', fn() => redirect()->route('admin.account-configuration.index'))->where('any', '.*');

    // Account Configuration
    Route::get('/account-configuration', [MarketingTrackingController::class, 'index'])->name('admin.account-configuration.index');
    Route::post('/account-configuration/facebook', [MarketingTrackingController::class, 'updateFacebook'])->name('admin.account-configuration.facebook');
    Route::post('/account-configuration/tiktok', [MarketingTrackingController::class, 'updateTikTok'])->name('admin.account-configuration.tiktok');
    Route::post('/account-configuration/google', [MarketingTrackingController::class, 'updateGoogle'])->name('admin.account-configuration.google');
    Route::post('/account-configuration/snapchat', [MarketingTrackingController::class, 'updateSnapchat'])->name('admin.account-configuration.snapchat');
    Route::post('/account-configuration/pinterest', [MarketingTrackingController::class, 'updatePinterest'])->name('admin.account-configuration.pinterest');
    Route::post('/account-configuration/twitter', [MarketingTrackingController::class, 'updateTwitter'])->name('admin.account-configuration.twitter');
    Route::post('/account-configuration/linkedin', [MarketingTrackingController::class, 'updateLinkedIn'])->name('admin.account-configuration.linkedin');
    Route::post('/account-configuration/custom-api', [MarketingTrackingController::class, 'updateCustomApi'])->name('admin.account-configuration.custom-api');
    Route::post('/account-configuration/general', [MarketingTrackingController::class, 'updateGeneral'])->name('admin.account-configuration.general');
    Route::get('/account-configuration/test-facebook', [MarketingTrackingController::class, 'testFacebook'])->name('admin.account-configuration.test-facebook');
    Route::post('/account-configuration/oauth-credentials', [MarketingTrackingController::class, 'saveOAuthCredentials'])->name('admin.account-configuration.oauth-credentials');
    Route::get('/account-configuration/test-tiktok', [MarketingTrackingController::class, 'testTikTok'])->name('admin.account-configuration.test-tiktok');
    Route::get('/account-configuration/test-google', [MarketingTrackingController::class, 'testGoogle'])->name('admin.account-configuration.test-google');
    Route::get('/account-configuration/test-snapchat', [MarketingTrackingController::class, 'testSnapchat'])->name('admin.account-configuration.test-snapchat');
    Route::get('/account-configuration/test-pinterest', [MarketingTrackingController::class, 'testPinterest'])->name('admin.account-configuration.test-pinterest');
    Route::get('/account-configuration/test-twitter', [MarketingTrackingController::class, 'testTwitter'])->name('admin.account-configuration.test-twitter');
    Route::get('/account-configuration/test-linkedin', [MarketingTrackingController::class, 'testLinkedIn'])->name('admin.account-configuration.test-linkedin');
    Route::get('/account-configuration/test-custom-api', [MarketingTrackingController::class, 'testCustomApi'])->name('admin.account-configuration.test-custom-api');
    Route::post('/account-configuration/send-test-event', [MarketingTrackingController::class, 'sendTestEvent'])->name('admin.account-configuration.send-test-event');

    // Trigger Words (AI Compliance)
    Route::get('/trigger-words', [TriggerWordController::class, 'index'])->name('admin.trigger-words.index');
    Route::post('/trigger-words', [TriggerWordController::class, 'store'])->name('admin.trigger-words.store');
    Route::put('/trigger-words/{trigger_word}', [TriggerWordController::class, 'update'])->name('admin.trigger-words.update');
    Route::delete('/trigger-words/{trigger_word}', [TriggerWordController::class, 'destroy'])->name('admin.trigger-words.destroy');
    Route::post('/trigger-words/{trigger_word}/toggle', [TriggerWordController::class, 'toggle'])->name('admin.trigger-words.toggle');

    // AI Compliance Dashboard
    Route::get('/ai-compliance', [AiComplianceController::class, 'index'])->name('admin.ai-compliance.index');
    Route::get('/ai-compliance/refresh-health', [AiComplianceController::class, 'refreshHealth'])->name('admin.ai-compliance.refresh-health');
    Route::post('/ai-compliance/test-sanitization', [AiComplianceController::class, 'testSanitization'])->name('admin.ai-compliance.test');

    // Predictive Dashboard
    Route::get('/predictive', [PredictiveController::class, 'index'])->name('admin.predictive.index');
    Route::get('/predictive/data', [PredictiveController::class, 'data'])->name('admin.predictive.data');

    // Reviewer IPs
    Route::get('/reviewer-ips', [ReviewerIpController::class, 'index'])->name('admin.reviewer-ips.index');
    Route::post('/reviewer-ips', [ReviewerIpController::class, 'store'])->name('admin.reviewer-ips.store');
    Route::delete('/reviewer-ips/{reviewer_ip}', [ReviewerIpController::class, 'destroy'])->name('admin.reviewer-ips.destroy');
    Route::post('/reviewer-ips/{reviewer_ip}/toggle', [ReviewerIpController::class, 'toggle'])->name('admin.reviewer-ips.toggle');

    // Affiliate Management
    Route::get('/affiliates', [AdminAffiliateController::class, 'index'])->name('admin.affiliates.index');
    Route::get('/affiliates/commissions/list', [AdminAffiliateController::class, 'commissions'])->name('admin.affiliates.commissions');
    Route::get('/affiliates/payouts/list', [AdminAffiliateController::class, 'payouts'])->name('admin.affiliates.payouts');
    Route::get('/affiliates/{affiliate}', [AdminAffiliateController::class, 'show'])->name('admin.affiliates.show');
    Route::patch('/affiliates/{affiliate}/status', [AdminAffiliateController::class, 'updateStatus'])->name('admin.affiliates.status');
    Route::patch('/affiliates/{affiliate}/commission', [AdminAffiliateController::class, 'updateCommission'])->name('admin.affiliates.commission');
    Route::patch('/affiliates/{affiliate}/tier', [AdminAffiliateController::class, 'updateTier'])->name('admin.affiliates.tier');
    Route::patch('/affiliates/{affiliate}/notes', [AdminAffiliateController::class, 'notes'])->name('admin.affiliates.notes');
    Route::patch('/affiliates/commissions/{commission}/approve', [AdminAffiliateController::class, 'approveCommission'])->name('admin.affiliates.commissions.approve');
    Route::patch('/affiliates/commissions/{commission}/reject', [AdminAffiliateController::class, 'rejectCommission'])->name('admin.affiliates.commissions.reject');
    Route::patch('/affiliates/payouts/{payout}/process', [AdminAffiliateController::class, 'processPayout'])->name('admin.affiliates.payouts.process');

    // Blog Management
    Route::get('/blog', [AdminBlogController::class, 'index'])->name('admin.blog.index');
    Route::get('/blog/create', [AdminBlogController::class, 'create'])->name('admin.blog.create');
    Route::post('/blog', [AdminBlogController::class, 'store'])->name('admin.blog.store');
    Route::get('/blog/{blog}/edit', [AdminBlogController::class, 'edit'])->name('admin.blog.edit');
    Route::put('/blog/{blog}', [AdminBlogController::class, 'update'])->name('admin.blog.update');
    Route::delete('/blog/{blog}', [AdminBlogController::class, 'destroy'])->name('admin.blog.destroy');
    Route::patch('/blog/{blog}/toggle', [AdminBlogController::class, 'toggle'])->name('admin.blog.toggle');
    Route::patch('/blog/{id}/restore', [AdminBlogController::class, 'restore'])->name('admin.blog.restore');
    Route::delete('/blog/trash/empty', [AdminBlogController::class, 'emptyTrash'])->name('admin.blog.empty-trash');
    Route::post('/blog/upload-inline-image', [AdminBlogController::class, 'uploadInlineImage'])->name('admin.blog.upload-inline-image');

    // Facebook Leads Hub
    Route::get('/leads-hub', [MetaLeadHubController::class, 'index'])->name('admin.leads-hub.index');
    Route::get('/leads-hub/filter', [MetaLeadHubController::class, 'filter'])->name('admin.leads-hub.filter');
    Route::get('/leads-hub/stats', [MetaLeadHubController::class, 'stats'])->name('admin.leads-hub.stats');
    Route::post('/leads-hub/sync', [MetaLeadHubController::class, 'sync'])->name('admin.leads-hub.sync');
    Route::post('/leads-hub/sync-facebook', [MetaLeadHubController::class, 'syncFromFacebook'])->name('admin.leads-hub.sync-facebook');
    Route::post('/leads-hub/bulk-message', [MetaLeadHubController::class, 'bulkMessage'])->name('admin.leads-hub.bulk-message');
    Route::get('/leads-hub/bulk-campaigns', [MetaLeadHubController::class, 'bulkCampaigns'])->name('admin.leads-hub.bulk-campaigns');
    Route::get('/leads-hub/bulk-campaigns/{campaign}', [MetaLeadHubController::class, 'bulkCampaignShow'])->name('admin.leads-hub.bulk-campaigns.show');
    Route::get('/leads-hub/export', [MetaLeadHubController::class, 'exportExcel'])->name('admin.leads-hub.export');
    Route::get('/leads-hub/export-selected', [MetaLeadHubController::class, 'exportSelected'])->name('admin.leads-hub.export-selected');
    Route::get('/leads-hub/{lead}', [MetaLeadHubController::class, 'show'])->name('admin.leads-hub.show');
    Route::post('/leads-hub/{lead}/score', [MetaLeadHubController::class, 'updateScore'])->name('admin.leads-hub.score');
    Route::post('/leads-hub/{lead}/stage', [MetaLeadHubController::class, 'updateStage'])->name('admin.leads-hub.stage');
    Route::post('/leads-hub/{lead}/tag', [MetaLeadHubController::class, 'addTag'])->name('admin.leads-hub.tag');
    Route::delete('/leads-hub/{lead}/tag', [MetaLeadHubController::class, 'removeTag'])->name('admin.leads-hub.remove-tag');

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('admin.reviews.show');
    Route::post('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('admin.reviews.approve');
    Route::post('/reviews/{review}/reject', [ReviewController::class, 'reject'])->name('admin.reviews.reject');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

    // ROAS
    Route::get('/roas', [RoasController::class, 'index'])->name('admin.roas.index');
    Route::get('/roas/data', [RoasController::class, 'data'])->name('admin.roas.data');

    // Ad Alerts
    Route::get('/ad-alerts', [AdAlertController::class, 'index'])->name('admin.ad-alerts.index');
    Route::get('/ad-alerts/pause-log', [AdAlertController::class, 'pauseLog'])->name('admin.ad-alerts.pause-log');
    Route::post('/ad-alerts/{alert}/acknowledge', [AdAlertController::class, 'acknowledge'])->name('admin.ad-alerts.acknowledge');
    Route::post('/ad-alerts/{alert}/resolve', [AdAlertController::class, 'resolve'])->name('admin.ad-alerts.resolve');
    Route::delete('/ad-alerts/{alert}', [AdAlertController::class, 'destroy'])->name('admin.ad-alerts.destroy');
    Route::get('/ad-alerts/health-summary', [AdAlertController::class, 'healthSummary'])->name('admin.ad-alerts.health-summary');
    Route::get('/ad-alerts/active-count', [AdAlertController::class, 'activeAlertsCount'])->name('admin.ad-alerts.active-count');

    // AI Creative Copilot
    Route::prefix('ai-creative')->group(function () {
        Route::get('/', [AiCreativeController::class, 'index'])->name('admin.ai-creative.index');
        Route::get('/generate', [AiCreativeController::class, 'generateForm'])->name('admin.ai-creative.generate-form');
        Route::post('/generate', [AiCreativeController::class, 'generate'])->name('admin.ai-creative.generate');
        Route::post('/store', [AiCreativeController::class, 'store'])->name('admin.ai-creative.store');
        Route::delete('/{id}', [AiCreativeController::class, 'destroy'])->name('admin.ai-creative.destroy');
    });

    // Audience Builder
    Route::prefix('audiences')->group(function () {
        Route::get('/', [AudienceController::class, 'index'])->name('admin.audiences.index');
        Route::get('/create', [AudienceController::class, 'create'])->name('admin.audiences.create');
        Route::post('/', [AudienceController::class, 'store'])->name('admin.audiences.store');
        Route::get('/{audience}', [AudienceController::class, 'show'])->name('admin.audiences.show');
        Route::post('/{audience}/sync', [AudienceController::class, 'sync'])->name('admin.audiences.sync');
        Route::post('/{audience}/push', [AudienceController::class, 'pushToPlatform'])->name('admin.audiences.push');
        Route::delete('/{audience}', [AudienceController::class, 'destroy'])->name('admin.audiences.destroy');
        Route::post('/lookalike', [AudienceController::class, 'createLookalike'])->name('admin.audiences.lookalike');
        Route::post('/overlap', [AudienceController::class, 'overlapAnalysis'])->name('admin.audiences.overlap');
    });

    // ============================================================
    // Meta Advanced Tools
    // ============================================================

    // WhatsApp
    Route::get('/meta-tools/whatsapp', [MetaToolsController::class, 'whatsappDashboard'])->name('admin.meta-tools.whatsapp');
    Route::post('/meta-tools/whatsapp/send', [MetaToolsController::class, 'whatsappSend'])->name('admin.meta-tools.whatsapp-send');
    Route::post('/meta-tools/whatsapp/bulk', [MetaToolsController::class, 'whatsappBulkSend'])->name('admin.meta-tools.whatsapp-bulk');
    Route::get('/meta-tools/whatsapp/test', [MetaToolsController::class, 'whatsappTest'])->name('admin.meta-tools.whatsapp-test');

    // Conversations
    Route::get('/meta-tools/conversations', [MetaToolsController::class, 'conversationsIndex'])->name('admin.meta-tools.conversations');
    Route::get('/meta-tools/conversations/{id}/messages', [MetaToolsController::class, 'conversationsMessages'])->name('admin.meta-tools.conversation-messages');
    Route::post('/meta-tools/conversations/reply', [MetaToolsController::class, 'conversationsReply'])->name('admin.meta-tools.conversation-reply');
    Route::get('/meta-tools/conversations/unread', [MetaToolsController::class, 'conversationsUnread'])->name('admin.meta-tools.conversation-unread');

    // Pixel Helper
    Route::get('/meta-tools/pixel-helper', [MetaToolsController::class, 'pixelHelperIndex'])->name('admin.meta-tools.pixel-helper');
    Route::get('/meta-tools/pixel-helper/verify', [MetaToolsController::class, 'pixelHelperVerify'])->name('admin.meta-tools.pixel-verify');
    Route::get('/meta-tools/pixel-helper/health', [MetaToolsController::class, 'pixelHelperHealth'])->name('admin.meta-tools.pixel-health');

    // A/B Testing
    Route::get('/meta-tools/ab-tests', [MetaToolsController::class, 'abTestsIndex'])->name('admin.ab-tests.index');
    Route::post('/meta-tools/ab-tests', [MetaToolsController::class, 'abTestsCreate'])->name('admin.ab-tests.create');
    Route::get('/meta-tools/ab-tests/{id}/analyze', [MetaToolsController::class, 'abTestsAnalyze'])->name('admin.ab-tests.analyze');
    Route::post('/meta-tools/ab-tests/{id}/winner', [MetaToolsController::class, 'abTestsDeclareWinner'])->name('admin.ab-tests.winner');

    // Instagram
    Route::get('/meta-tools/instagram', [MetaToolsController::class, 'instagramDashboard'])->name('admin.meta-tools.instagram');
    Route::get('/meta-tools/instagram/insights', [MetaToolsController::class, 'instagramInsights'])->name('admin.meta-tools.instagram-insights');
    Route::get('/meta-tools/instagram/top-posts', [MetaToolsController::class, 'instagramTopPosts'])->name('admin.meta-tools.instagram-top-posts');

    // Audience Upload
    Route::get('/meta-tools/audience-upload', [MetaToolsController::class, 'audienceUploadIndex'])->name('admin.meta-tools.audience-upload');
    Route::post('/meta-tools/audience-upload/csv', [MetaToolsController::class, 'audienceUploadCsv'])->name('admin.meta-tools.audience-upload-csv');
    Route::post('/meta-tools/audience-upload/phones', [MetaToolsController::class, 'audienceUploadPhones'])->name('admin.meta-tools.audience-upload-phones');
    Route::post('/meta-tools/audience-upload/emails', [MetaToolsController::class, 'audienceUploadEmails'])->name('admin.meta-tools.audience-upload-emails');
    Route::get('/meta-tools/audience-upload/template', [MetaToolsController::class, 'audienceTemplate'])->name('admin.meta-tools.audience-template');

    // Enhanced Matching
    Route::post('/meta-tools/enhanced-matching/test', [MetaToolsController::class, 'enhancedMatchingTest'])->name('admin.meta-tools.enhanced-matching');

    // ============================================================
    // Meta Advanced Features (Analytics, Automation, Creative, Compliance, Leads, Targeting)
    // ============================================================

    Route::prefix('meta-advanced')->name('admin.meta-advanced.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'dashboard'])->name('dashboard');

        // Analytics
        Route::get('/analytics', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'analyticsIndex'])->name('analytics');

        // Automation
        Route::get('/automation', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'automationIndex'])->name('automation');
        Route::post('/automation/rules', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'createAutomationRule'])->name('automation.rules.store');
        Route::put('/automation/rules/{id}', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'updateAutomationRule'])->name('automation.rules.update');
        Route::delete('/automation/rules/{id}', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'deleteAutomationRule'])->name('automation.rules.destroy');
        Route::post('/automation/execute', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'executeAutomationRules'])->name('automation.execute');
        Route::post('/automation/schedule', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'scheduleCampaignAction'])->name('automation.schedule');
        Route::post('/automation/scheduled/{id}/cancel', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'cancelScheduledAction'])->name('automation.schedule.cancel');

        // Creative Optimization
        Route::get('/creative', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'creativeIndex'])->name('creative');
        Route::get('/creative/{id}/analyze', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'analyzeCreativeFatigue'])->name('creative.analyze');
        Route::get('/creative/{id}/suggestions', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'getCreativeSuggestions'])->name('creative.suggestions');
        Route::post('/creative/compare', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'compareCreatives'])->name('creative.compare');

        // Compliance
        Route::get('/compliance', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'complianceIndex'])->name('compliance');
        Route::post('/compliance/issues/{id}/resolve', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'resolveComplianceIssue'])->name('compliance.resolve');
        Route::get('/compliance/health/{accountId}', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'checkAccountHealth'])->name('compliance.health');
        Route::post('/compliance/spending-limits', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'createSpendingLimit'])->name('compliance.limits.store');
        Route::post('/compliance/check-limits', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'checkSpendingLimits'])->name('compliance.limits.check');

        // Leads
        Route::get('/leads', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'leadsIndex'])->name('leads');
        Route::post('/leads/{leadId}/conversion', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'trackLeadConversion'])->name('leads.conversion');
        Route::post('/leads/auto-score', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'autoScoreLeads'])->name('leads.auto-score');

        // Targeting
        Route::get('/targeting', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'targetingIndex'])->name('targeting');
        Route::post('/targeting/lookalike', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'createLookalikeAudience'])->name('targeting.lookalike');
        Route::post('/targeting/retargeting', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'createRetargetingAudience'])->name('targeting.retargeting');
        Route::get('/targeting/suggestions/{campaignId}', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'getAudienceSuggestions'])->name('targeting.suggestions');

        // Reports
        Route::get('/reports', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'reportsIndex'])->name('reports');
        Route::post('/reports', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'createAutomatedReport'])->name('reports.store');
        Route::post('/reports/{id}/generate', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'generateReport'])->name('reports.generate');
        Route::delete('/reports/{id}', [\App\Http\Controllers\Admin\MetaAdvancedController::class, 'deleteAutomatedReport'])->name('reports.destroy');
    });
});

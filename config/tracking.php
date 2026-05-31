<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Health Scoring
    |--------------------------------------------------------------------------
    */
    'health' => [
        'check_interval_minutes' => env('TRACKING_HEALTH_INTERVAL', 15),
        'alert_threshold' => env('TRACKING_HEALTH_ALERT_THRESHOLD', 50),
        'auto_pause_threshold' => env('TRACKING_HEALTH_PAUSE_THRESHOLD', 30),
        'auto_pause_enabled' => env('TRACKING_HEALTH_AUTO_PAUSE', true),
        'recovery_threshold' => env('TRACKING_HEALTH_RECOVERY', 70),

        'rejection_weight' => env('TRACKING_HEALTH_REJECTION_WEIGHT', 30),
        'error_weight' => env('TRACKING_HEALTH_ERROR_WEIGHT', 25),
        'duplicate_weight' => env('TRACKING_HEALTH_DUPLICATE_WEIGHT', 15),
        'sanitization_weight' => env('TRACKING_HEALTH_SANITIZATION_WEIGHT', 10),

        'lookback_days' => env('TRACKING_HEALTH_LOOKBACK_DAYS', 7),
    ],

    /*
    |--------------------------------------------------------------------------
    | Spend Anomaly Detection
    |--------------------------------------------------------------------------
    */
    'spend' => [
        'check_interval_minutes' => env('TRACKING_SPEND_INTERVAL', 30),
        'enabled' => env('TRACKING_SPEND_ENABLED', true),

        'hourly_spike_threshold' => env('TRACKING_SPEND_HOURLY_SPIKE', 2.0),
        'daily_budget_warning_pct' => env('TRACKING_SPEND_DAILY_WARNING', 80),
        'daily_budget_critical_pct' => env('TRACKING_SPEND_DAILY_CRITICAL', 100),
        'cpa_spike_threshold' => env('TRACKING_SPEND_CPA_SPIKE', 2.0),
        'cpa_lookback_hours' => env('TRACKING_SPEND_CPA_LOOKBACK', 24),
        'emq_drop_threshold' => env('TRACKING_SPEND_EMQ_DROP', 0.7),
        'min_conversions_for_analysis' => env('TRACKING_SPEND_MIN_CONVERSIONS', 5),
    ],

    /*
    |--------------------------------------------------------------------------
    | Traffic Quality Scoring
    |--------------------------------------------------------------------------
    */
    'traffic_quality' => [
        'enabled' => env('TRACKING_TRAFFIC_QUALITY_ENABLED', true),

        'bot_score_weight' => env('TRACKING_TRAFFIC_BOT_WEIGHT', 0.4),
        'click_velocity_weight' => env('TRACKING_TRAFFIC_VELOCITY_WEIGHT', 0.3),
        'ip_reputation_weight' => env('TRACKING_TRAFFIC_IP_WEIGHT', 0.3),

        'quality_threshold_critical' => env('TRACKING_TRAFFIC_CRITICAL', 30),
        'quality_threshold_warning' => env('TRACKING_TRAFFIC_WARNING', 50),

        'max_clicks_per_hour_per_ip' => env('TRACKING_TRAFFIC_MAX_CLICKS_IP', 10),
        'max_clicks_per_hour_per_session' => env('TRACKING_TRAFFIC_MAX_CLICKS_SESSION', 20),
        'click_velocity_window_minutes' => env('TRACKING_TRAFFIC_VELOCITY_WINDOW', 60),

        'known_bot_ips' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-Pause Engine
    |--------------------------------------------------------------------------
    */
    'auto_pause' => [
        'enabled' => env('TRACKING_AUTO_PAUSE_ENABLED', true),
        'cooldown_minutes' => env('TRACKING_AUTO_PAUSE_COOLDOWN', 120),
        'max_pauses_per_day' => env('TRACKING_AUTO_PAUSE_MAX_DAILY', 5),
        'notify_on_pause' => env('TRACKING_AUTO_PAUSE_NOTIFY', true),
        'auto_resume_enabled' => env('TRACKING_AUTO_PAUSE_RESUME', false),
        'resume_check_interval_minutes' => env('TRACKING_AUTO_PAUSE_RESUME_INTERVAL', 60),
    ],

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    'notifications' => [
        'slack_webhook' => env('TRACKING_SLACK_WEBHOOK', ''),
        'telegram_bot_token' => env('TRACKING_TELEGRAM_BOT_TOKEN', ''),
        'telegram_chat_id' => env('TRACKING_TELEGRAM_CHAT_ID', ''),
        'notify_on' => [
            'health_critical' => env('TRACKING_NOTIFY_HEALTH_CRITICAL', true),
            'spend_anomaly' => env('TRACKING_NOTIFY_SPEND_ANOMALY', true),
            'auto_pause' => env('TRACKING_NOTIFY_AUTO_PAUSE', true),
            'auto_resume' => env('TRACKING_NOTIFY_AUTO_RESUME', false),
            'traffic_drop' => env('TRACKING_NOTIFY_TRAFFIC_DROP', true),
            'webhook_received' => env('TRACKING_NOTIFY_WEBHOOK', true),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Bot Detection (used by BehavioralController & TrafficQualityService)
    |--------------------------------------------------------------------------
    */
    'bot_detection' => [
        'known_bot_ips' => [],
        'bot_user_agent_patterns' => [
            'bot', 'crawl', 'spider', 'scrape', 'curl', 'wget',
            'python', 'httpclient', 'go-http-client',
            'headless', 'phantom', 'selenium', 'puppeteer', 'playwright',
        ],
        'server_score_increments' => [
            'ua_pattern' => 25,
            'known_ip' => 30,
            'empty_ua' => 20,
            'no_accept_language' => 15,
        ],
    ],
];

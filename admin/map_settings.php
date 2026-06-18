<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/includes/auth.php';
require_roles(['superadmin', 'admin']);

$lang = current_lang();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $map_config = [
        'latitude' => $_POST['latitude'] ?? '31.927778',
        'longitude' => $_POST['longitude'] ?? '35.216417',
        'zoom' => $_POST['zoom'] ?? '18',
        'map_type' => $_POST['map_type'] ?? 'roadmap',
        'width' => $_POST['width'] ?? '100%',
        'height' => $_POST['height'] ?? '400px',
        'border_radius' => $_POST['border_radius'] ?? '10px',
        'show_marker' => isset($_POST['show_marker']),
        'show_controls' => isset($_POST['show_controls']),
        'show_street_view' => isset($_POST['show_street_view']),
        'show_fullscreen' => isset($_POST['show_fullscreen']),
        'map_style' => $_POST['map_style'] ?? 'default',
        'custom_marker_color' => $_POST['custom_marker_color'] ?? '#2563eb'
    ];
    
    // Save to database
    $stmt = db()->prepare("UPDATE settings SET value = ? WHERE key = 'map_config'");
    $stmt->execute([json_encode($map_config)]);
    
    $success = true;
}

// Get current map config
$stmt = db()->prepare("SELECT value FROM settings WHERE key = 'map_config'");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$map_config = $result ? json_decode($result['value'], true) : [
    'latitude' => '31.927778',
    'longitude' => '35.216417',
    'zoom' => '18',
    'map_type' => 'roadmap',
    'width' => '100%',
    'height' => '400px',
    'border_radius' => '10px',
    'show_marker' => true,
    'show_controls' => true,
    'show_street_view' => true,
    'show_fullscreen' => true,
    'map_style' => 'default',
    'custom_marker_color' => '#2563eb'
];

include __DIR__ . '/partials/header.php';

?>

<style>
    :root {
        --primary: #2563eb;
        --primary-light: #3b82f6;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --dark: #1f2937;
        --light: #f8fafc;
    }
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 20px;
    }
    
    .admin-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        padding: 40px;
        margin-bottom: 30px;
        border: none;
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 30px 0 20px 0;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .map-container {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        margin: 20px 0;
        position: relative;
    }
    
    .coordinate-input {
        font-family: 'Courier New', monospace;
        font-size: 14px;
    }
    
    .zoom-slider {
        width: 100%;
    }
    
    .style-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin: 20px 0;
    }
    
    .style-option {
        padding: 15px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }
    
    .style-option:hover {
        border-color: var(--primary);
        transform: translateY(-2px);
    }
    
    .style-option.active {
        border-color: var(--primary);
        background: var(--primary);
        color: white;
    }
    
    .control-panel {
        background: #f8fafc;
        border-radius: 10px;
        padding: 20px;
        margin: 20px 0;
    }
    
    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
    }
    
    .icon-large {
        font-size: 3rem;
        margin-bottom: 20px;
        color: var(--primary);
    }
    
    .alert-custom {
        border-radius: 10px;
        border: none;
        padding: 15px 20px;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 8px;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    
    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .slider {
        background-color: var(--primary);
    }
    
    input:checked + .slider:before {
        transform: translateX(26px);
    }
    
    .dimensions-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .color-input-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .color-preview {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
    }
</style>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 fw-bold m-0">
        <i class="fas fa-map-marked-alt text-primary"></i>
        <?= $lang === 'ar' ? 'إعدادات الخريطة' : 'Map Settings' ?>
    </h1>
    <div class="text-muted">
        <i class="fas fa-info-circle"></i>
        <?= $lang === 'ar' ? 'تحكم دقيق في عرض الخريطة وموقعها' : 'Precise control over map display and location' ?>
    </div>
</div>

            <?php if (isset($success)): ?>
                <div class="alert alert-success alert-custom">
                    <i class="fas fa-check-circle"></i>
                    <?= $lang === 'ar' ? 'تم حفظ الإعدادات بنجاح' : 'Settings saved successfully' ?>
                </div>
            <?php endif; ?>

            <form method="POST" id="mapSettingsForm">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="section-title">
                            <i class="fas fa-location-dot"></i>
                            <?= $lang === 'ar' ? 'الإحداثيات الدقيقة' : 'Precise Coordinates' ?>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-compass"></i>
                                <?= $lang === 'ar' ? 'خط العرض (Latitude)' : 'Latitude' ?>
                            </label>
                            <input type="text" name="latitude" class="form-control coordinate-input" 
                                   value="<?= htmlspecialchars($map_config['latitude']) ?>" 
                                   placeholder="31.927778"
                                   required>
                            <small class="text-muted">
                                <?= $lang === 'ar' ? 'استخدم 15 خانة عشرية لأقصى دقة' : 'Use 15 decimal places for maximum precision' ?>
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-globe"></i>
                                <?= $lang === 'ar' ? 'خط الطول (Longitude)' : 'Longitude' ?>
                            </label>
                            <input type="text" name="longitude" class="form-control coordinate-input" 
                                   value="<?= htmlspecialchars($map_config['longitude']) ?>" 
                                   placeholder="35.216417"
                                   required>
                            <small class="text-muted">
                                <?= $lang === 'ar' ? 'استخدم 15 خانة عشرية لأقصى دقة' : 'Use 15 decimal places for maximum precision' ?>
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-search-plus"></i>
                                <?= $lang === 'ar' ? 'مستوى التقريب (Zoom Level)' : 'Zoom Level' ?>
                            </label>
                            <input type="range" name="zoom" class="form-range zoom-slider" 
                                   min="1" max="20" value="<?= $map_config['zoom'] ?>">
                            <div class="d-flex justify-content-between">
                                <small>1 (<?= $lang === 'ar' ? 'العالم' : 'World' ?>)</small>
                                <strong><?= $map_config['zoom'] ?></strong>
                                <small>20 (<?= $lang === 'ar' ? 'أقرب' : 'Closest' ?>)</small>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-map"></i>
                                <?= $lang === 'ar' ? 'نوع الخريطة' : 'Map Type' ?>
                            </label>
                            <select name="map_type" class="form-select">
                                <option value="roadmap" <?= $map_config['map_type'] === 'roadmap' ? 'selected' : '' ?>>
                                    <?= $lang === 'ar' ? 'خريطة طرق' : 'Roadmap' ?>
                                </option>
                                <option value="satellite" <?= $map_config['map_type'] === 'satellite' ? 'selected' : '' ?>>
                                    <?= $lang === 'ar' ? 'قمر صناعي' : 'Satellite' ?>
                                </option>
                                <option value="hybrid" <?= $map_config['map_type'] === 'hybrid' ? 'selected' : '' ?>>
                                    <?= $lang === 'ar' ? 'هجين' : 'Hybrid' ?>
                                </option>
                                <option value="terrain" <?= $map_config['map_type'] === 'terrain' ? 'selected' : '' ?>>
                                    <?= $lang === 'ar' ? 'تضاريس' : 'Terrain' ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="section-title">
                            <i class="fas fa-ruler-combined"></i>
                            <?= $lang === 'ar' ? 'الأبعاد والتصميم' : 'Dimensions and Design' ?>
                        </div>
                        
                        <div class="dimensions-grid">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-arrows-alt-h"></i>
                                    <?= $lang === 'ar' ? 'العرض' : 'Width' ?>
                                </label>
                                <input type="text" name="width" class="form-control" 
                                       value="<?= htmlspecialchars($map_config['width']) ?>" 
                                       placeholder="100%">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-arrows-alt-v"></i>
                                    <?= $lang === 'ar' ? 'الارتفاع' : 'Height' ?>
                                </label>
                                <input type="text" name="height" class="form-control" 
                                       value="<?= htmlspecialchars($map_config['height']) ?>" 
                                       placeholder="400px">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-shapes"></i>
                                <?= $lang === 'ar' ? 'انحناء الحواف' : 'Border Radius' ?>
                            </label>
                            <input type="text" name="border_radius" class="form-control" 
                                   value="<?= htmlspecialchars($map_config['border_radius']) ?>" 
                                   placeholder="10px">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-palette"></i>
                                <?= $lang === 'ar' ? 'لون العلامة المخصص' : 'Custom Marker Color' ?>
                            </label>
                            <div class="color-input-wrapper">
                                <input type="color" name="custom_marker_color" 
                                       value="<?= htmlspecialchars($map_config['custom_marker_color']) ?>" 
                                       class="form-control form-control-color">
                                <div class="color-preview" style="background: <?= htmlspecialchars($map_config['custom_marker_color']) ?>"></div>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($map_config['custom_marker_color']) ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="section-title">
                            <i class="fas fa-cog"></i>
                            <?= $lang === 'ar' ? 'عناصر التحكم' : 'Control Elements' ?>
                        </div>
                        
                        <div class="control-panel">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="show_marker" 
                                       <?= $map_config['show_marker'] ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    <i class="fas fa-map-pin"></i>
                                    <?= $lang === 'ar' ? 'إظهار علامة الموقع' : 'Show Location Marker' ?>
                                </label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="show_controls" 
                                       <?= $map_config['show_controls'] ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    <i class="fas fa-sliders"></i>
                                    <?= $lang === 'ar' ? 'إظهار أدوات التحكم' : 'Show Controls' ?>
                                </label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="show_street_view" 
                                       <?= $map_config['show_street_view'] ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    <i class="fas fa-street-view"></i>
                                    <?= $lang === 'ar' ? 'إظهار عرض الشارع' : 'Show Street View' ?>
                                </label>
                            </div>
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="show_fullscreen" 
                                       <?= $map_config['show_fullscreen'] ? 'checked' : '' ?>>
                                <label class="form-check-label">
                                    <i class="fas fa-expand"></i>
                                    <?= $lang === 'ar' ? 'إظهار ملء الشاشة' : 'Show Fullscreen' ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="section-title">
                    <i class="fas fa-paint-brush"></i>
                    <?= $lang === 'ar' ? 'أنماط الخريطة' : 'Map Styles' ?>
                </div>
                
                <div class="style-grid">
                    <div class="style-option <?= $map_config['map_style'] === 'default' ? 'active' : '' ?>" 
                         data-style="default">
                        <i class="fas fa-map fa-2x mb-2"></i>
                        <div><?= $lang === 'ar' ? 'افتراضي' : 'Default' ?></div>
                    </div>
                    <div class="style-option <?= $map_config['map_style'] === 'silver' ? 'active' : '' ?>" 
                         data-style="silver">
                        <i class="fas fa-moon fa-2x mb-2"></i>
                        <div><?= $lang === 'ar' ? 'فضي' : 'Silver' ?></div>
                    </div>
                    <div class="style-option <?= $map_config['map_style'] === 'dark' ? 'active' : '' ?>" 
                         data-style="dark">
                        <i class="fas fa-adjust fa-2x mb-2"></i>
                        <div><?= $lang === 'ar' ? 'داكن' : 'Dark' ?></div>
                    </div>
                    <div class="style-option <?= $map_config['map_style'] === 'night' ? 'active' : '' ?>" 
                         data-style="night">
                        <i class="fas fa-star fa-2x mb-2"></i>
                        <div><?= $lang === 'ar' ? 'ليلي' : 'Night' ?></div>
                    </div>
                    <div class="style-option <?= $map_config['map_style'] === 'retro' ? 'active' : '' ?>" 
                         data-style="retro">
                        <i class="fas fa-history fa-2x mb-2"></i>
                        <div><?= $lang === 'ar' ? 'ريترو' : 'Retro' ?></div>
                    </div>
                    <div class="style-option <?= $map_config['map_style'] === 'aqua' ? 'active' : '' ?>" 
                         data-style="aqua">
                        <i class="fas fa-water fa-2x mb-2"></i>
                        <div><?= $lang === 'ar' ? 'مائي' : 'Aqua' ?></div>
                    </div>
                </div>
                
                <input type="hidden" name="map_style" id="selectedMapStyle" value="<?= $map_config['map_style'] ?>">
                
                <div class="section-title">
                    <i class="fas fa-eye"></i>
                    <?= $lang === 'ar' ? 'معاينة مباشرة' : 'Live Preview' ?>
                </div>
                
                <?php
                    $typeMap = ['roadmap'=>'m','satellite'=>'k','hybrid'=>'h','terrain'=>'p'];
                    $t       = $typeMap[$map_config['map_type']] ?? 'm';
                    $previewUrl = "https://maps.google.com/maps?q=" . urlencode($map_config['latitude']) . "," . urlencode($map_config['longitude']) . "&z=" . intval($map_config['zoom']) . "&t={$t}&output=embed";
                ?>
                <div class="map-container" id="mapPreview" 
                     style="width: <?= htmlspecialchars($map_config['width']) ?>; 
                            height: <?= htmlspecialchars($map_config['height']) ?>; 
                            border-radius: <?= htmlspecialchars($map_config['border_radius']) ?>">
                    <iframe 
                        id="mapFrame"
                        src="<?= htmlspecialchars($previewUrl) ?>"
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="fas fa-save"></i>
                        <?= $lang === 'ar' ? 'حفظ الإعدادات' : 'Save Settings' ?>
                    </button>
                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i>
                        <?= $lang === 'ar' ? 'العودة' : 'Back' ?>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Style selection
            $('.style-option').click(function() {
                $('.style-option').removeClass('active');
                $(this).addClass('active');
                $('#selectedMapStyle').val($(this).data('style'));
                updateMapPreview();
            });
            
            // Map type to Google Maps embed t= parameter
            const mapTypeCode = { roadmap: 'm', satellite: 'k', hybrid: 'h', terrain: 'p' };

            // Live preview updates
            function updateMapPreview() {
                const latitude    = $('input[name="latitude"]').val().trim();
                const longitude   = $('input[name="longitude"]').val().trim();
                const zoom        = parseInt($('input[name="zoom"]').val()) || 15;
                const mapType     = $('select[name="map_type"]').val();   // FIX: was input[name]
                const width       = $('input[name="width"]').val();
                const height      = $('input[name="height"]').val();
                const borderRadius = $('input[name="border_radius"]').val();

                if (!latitude || !longitude) return;

                // Update map container dimensions
                $('#mapPreview').css({
                    'width': width,
                    'height': height,
                    'border-radius': borderRadius
                });

                // Build correct embed URL
                const t = mapTypeCode[mapType] || 'm';
                const q = encodeURIComponent(latitude + ',' + longitude);
                const mapUrl = `https://maps.google.com/maps?q=${q}&z=${zoom}&t=${t}&output=embed`;
                $('#mapFrame').attr('src', mapUrl);
            }

            // Update on input/select change
            $('input[name="latitude"], input[name="longitude"], input[name="zoom"], select[name="map_type"], input[name="width"], input[name="height"], input[name="border_radius"]').on('input change', updateMapPreview);
            
            // Update zoom display
            $('input[name="zoom"]').on('input', function() {
                $(this).siblings('.d-flex').find('strong').text($(this).val());
            });
            
            // Update color preview
            $('input[name="custom_marker_color"]').on('input', function() {
                const color = $(this).val();
                $(this).siblings('.color-preview').css('background', color);
                $(this).siblings('input[type="text"]').val(color);
            });
            
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>

<?php include __DIR__ . '/partials/footer.php'; ?>

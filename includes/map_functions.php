<?php
/**
 * Advanced Map Display System for Sawa Car Rental
 * Uses configuration from admin panel for precise positioning
 */

function get_map_config() {
    static $config = null;
    if ($config !== null) {
        return $config;
    }
    
    $stmt = db()->prepare("SELECT value FROM settings WHERE key = 'map_config'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        $config = json_decode($result['value'], true);
    } else {
        // Default configuration
        $config = [
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
    }
    
    return $config;
}

function generate_google_maps_embed($config = null) {
    if ($config === null) {
        $config = get_map_config();
    }
    
    $lat = $config['latitude'];
    $lng = $config['longitude'];
    $zoom = $config['zoom'];
    $mapType = $config['map_type'];
    
    // Generate Google Maps embed URL
    $embedUrl = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3385.897!2d{$lng}!3d{$lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f{$zoom}!3m3!1m2!1s0x0%3A0x0!2zMzHCsDU1JzM5LjkiTiAzNcKwMTMnNTkuMyJF!5e0!3m2!1sar!2sps!4v1234567890";
    
    return $embedUrl;
}

function generate_google_maps_directions_url($config = null) {
    if ($config === null) {
        $config = get_map_config();
    }
    
    $lat = $config['latitude'];
    $lng = $config['longitude'];
    
    return "https://www.google.com/maps/dir/?api=1&destination={$lat},{$lng}";
}

function generate_google_maps_search_url($config = null) {
    if ($config === null) {
        $config = get_map_config();
    }
    
    $lat = $config['latitude'];
    $lng = $config['longitude'];
    
    return "https://www.google.com/maps/search/?api=1&query={$lat},{$lng}";
}

function render_map_embed($style = 'default', $class = 'advanced-map-embed') {
    $config = get_map_config();
    $embedUrl = generate_google_maps_embed($config);
    
    $styleAttr = "width: {$config['width']}; height: {$config['height']}; border-radius: {$config['border_radius']}; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.2);";
    
    $html = '<div class="map-container ' . $class . '" style="' . $styleAttr . '">';
    $html .= '<iframe src="' . htmlspecialchars($embedUrl) . '" ';
    $html .= 'width="100%" height="100%" style="border:0;" ';
    $html .= 'allowfullscreen="" loading="lazy"></iframe>';
    $html .= '</div>';
    
    return $html;
}

function render_map_button($type = 'directions', $class = 'btn-map', $icon = true) {
    $config = get_map_config();
    
    if ($type === 'directions') {
        $url = generate_google_maps_directions_url($config);
        $text = current_lang() === 'ar' ? 'الاتجاهات في Google Maps' : 'Directions in Google Maps';
        $iconClass = $icon ? 'fas fa-directions' : '';
    } else {
        $url = generate_google_maps_search_url($config);
        $text = current_lang() === 'ar' ? 'بحث في Google Maps' : 'Search in Google Maps';
        $iconClass = $icon ? 'fas fa-search' : '';
    }
    
    $html = '<a href="' . htmlspecialchars($url) . '" ';
    $html .= 'target="_blank" class="' . $class . '" ';
    $html .= 'style="background: linear-gradient(135deg, #1a73e8, #34a853); color: white; text-decoration: none; padding: 12px 30px; border-radius: 25px; font-weight: 600; display: inline-block; margin: 10px; transition: all 0.3s ease;">';
    
    if ($icon && $iconClass) {
        $html .= '<i class="' . $iconClass . '"></i> ';
    }
    
    $html .= htmlspecialchars($text) . '</a>';
    
    return $html;
}

function render_map_card($title = null, $showButtons = true) {
    $lang = current_lang();
    $config = get_map_config();
    
    if ($title === null) {
        $title = $lang === 'ar' ? 'موقعنا على الخريطة' : 'Our Location';
    }
    
    $html = '<div class="map-card" style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); margin: 20px 0;">';
    
    if ($title) {
        $html .= '<h3 class="map-card-title" style="margin-bottom: 20px; color: #1f2937; font-weight: bold;">';
        $html .= '<i class="fas fa-map-marked-alt" style="color: #2563eb; margin-right: 10px;"></i>';
        $html .= htmlspecialchars($title) . '</h3>';
    }
    
    $html .= render_map_embed();
    
    if ($showButtons) {
        $html .= '<div class="map-buttons" style="text-align: center; margin-top: 20px;">';
        $html .= render_map_button('directions');
        $html .= render_map_button('search');
        $html .= '</div>';
    }
    
    $html .= '</div>';
    
    return $html;
}

function render_footer_map() {
    $config = get_map_config();
    $lang = current_lang();
    
    // Create a compact footer map with link
    $directionsUrl = generate_google_maps_directions_url($config);
    
    $html = '<!-- Google Map Link -->';
    $html .= '<a href="' . htmlspecialchars($directionsUrl) . '" target="_blank" rel="noopener" ';
    $html .= 'class="footer-map" style="margin-top:15px;border-radius:10px;overflow:hidden;height:120px;box-shadow: 0 4px 15px rgba(0,0,0,0.3); display:flex; align-items:center; justify-content:center; background: linear-gradient(135deg, #1a73e8, #34a853); text-decoration:none;">';
    $html .= '<div style="text-align:center; color: white;">';
    $html .= '<i class="fas fa-map-marked-alt" style="font-size: 2rem; margin-bottom: 8px;"></i>';
    $html .= '<div style="font-weight: 600; font-size: 0.85rem;">' . ($lang === 'ar' ? 'افتح في خرائط Google' : 'Open in Google Maps') . '</div>';
    $html .= '</div>';
    $html .= '</a>';
    
    return $html;
}

function get_map_coordinates_text($precision = 5) {
    $config = get_map_config();
    $lat = number_format((float)$config['latitude'], $precision);
    $lng = number_format((float)$config['longitude'], $precision);
    
    return [
        'latitude' => $lat . '°N',
        'longitude' => $lng . '°E',
        'full' => $lat . '°N, ' . $lng . '°E'
    ];
}

function validate_coordinates($lat, $lng) {
    $lat = (float)$lat;
    $lng = (float)$lng;
    
    // Valid latitude range: -90 to 90
    // Valid longitude range: -180 to 180
    // For Palestine, we expect: latitude ~31-33, longitude ~34-36
    
    $valid = ($lat >= -90 && $lat <= 90) && ($lng >= -180 && $lng <= 180);
    $inPalestine = ($lat >= 31 && $lat <= 33) && ($lng >= 34 && $lng <= 36);
    
    return [
        'valid' => $valid,
        'in_palestine' => $inPalestine,
        'message' => !$valid ? 'Invalid coordinates' : (!$inPalestine ? 'Coordinates not in Palestine range' : 'Valid coordinates')
    ];
}

// CSS styles for map components
function get_map_styles() {
    return '
        .map-container {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            position: relative;
        }
        
        .map-container iframe {
            border: none;
        }
        
        .map-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin: 20px 0;
        }
        
        .map-card-title {
            color: #1f2937;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .map-buttons {
            text-align: center;
            margin-top: 20px;
        }
        
        .btn-map {
            background: linear-gradient(135deg, #1a73e8, #34a853);
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            display: inline-block;
            margin: 10px;
            transition: all 0.3s ease;
        }
        
        .btn-map:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            color: white;
        }
        
        .footer-map {
            margin-top: 15px;
            border-radius: 10px;
            overflow: hidden;
            height: 120px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a73e8, #34a853);
            text-decoration: none;
        }
        
        .footer-map:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }
    ';
}
?>

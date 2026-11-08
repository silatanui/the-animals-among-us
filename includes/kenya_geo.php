<?php
declare(strict_types=1);

/**
 * Approximate Kenya county centroids and sample towns for portfolio map dots.
 */
function kenya_county_centroids(): array
{
    return [
        'Baringo' => [-0.49, 35.97],
        'Bomet' => [-0.78, 35.34],
        'Bungoma' => [0.57, 34.56],
        'Busia' => [0.46, 34.11],
        'Elgeyo-Marakwet' => [0.80, 35.50],
        'Embu' => [-0.54, 37.45],
        'Garissa' => [-0.45, 39.66],
        'Homa Bay' => [-0.53, 34.46],
        'Isiolo' => [0.35, 37.58],
        'Kajiado' => [-1.85, 36.78],
        'Kakamega' => [0.28, 34.75],
        'Kericho' => [-0.37, 35.28],
        'Kiambu' => [-1.17, 36.83],
        'Kilifi' => [-3.63, 39.85],
        'Kirinyaga' => [-0.50, 37.28],
        'Kisii' => [-0.68, 34.77],
        'Kisumu' => [-0.09, 34.77],
        'Kitui' => [-1.37, 38.01],
        'Kwale' => [-4.17, 39.45],
        'Laikipia' => [0.20, 36.78],
        'Lamu' => [-2.27, 40.90],
        'Machakos' => [-1.52, 37.27],
        'Makueni' => [-1.80, 37.62],
        'Mandera' => [3.94, 41.86],
        'Marsabit' => [2.33, 37.99],
        'Meru' => [0.05, 37.65],
        'Migori' => [-1.06, 34.47],
        'Mombasa' => [-4.04, 39.67],
        'Murang\'a' => [-0.78, 37.04],
        'Nairobi' => [-1.29, 36.82],
        'Nakuru' => [-0.30, 36.08],
        'Nandi' => [0.20, 35.12],
        'Narok' => [-1.08, 35.87],
        'Nyamira' => [-0.56, 34.94],
        'Nyandarua' => [-0.32, 36.47],
        'Nyeri' => [-0.42, 36.95],
        'Samburu' => [1.20, 36.95],
        'Siaya' => [0.06, 34.29],
        'Taita-Taveta' => [-3.40, 38.37],
        'Tana River' => [-1.50, 39.50],
        'Tharaka-Nithi' => [-0.30, 37.80],
        'Trans Nzoia' => [1.02, 34.99],
        'Turkana' => [3.12, 35.60],
        'Uasin Gishu' => [0.52, 35.27],
        'Vihiga' => [0.08, 34.72],
        'Wajir' => [1.75, 40.07],
        'West Pokot' => [1.60, 35.25],
    ];
}

/**
 * Known towns used for denser, overlapping case dots.
 * @return array<string, array{0:float,1:float,2:string}> lat, lng, county
 */
function kenya_town_points(): array
{
    return [
        'Nairobi CBD' => [-1.2864, 36.8172, 'Nairobi'],
        'Westlands' => [-1.2673, 36.8110, 'Nairobi'],
        'Kasarani' => [-1.2200, 36.8900, 'Nairobi'],
        'Kibera' => [-1.3120, 36.7850, 'Nairobi'],
        'Thika' => [-1.0333, 37.0693, 'Kiambu'],
        'Ruiru' => [-1.1480, 36.9630, 'Kiambu'],
        'Kiambu Town' => [-1.1714, 36.8356, 'Kiambu'],
        'Nakuru Town' => [-0.3031, 36.0800, 'Nakuru'],
        'Naivasha' => [-0.7172, 36.4310, 'Nakuru'],
        'Kisumu City' => [-0.0917, 34.7680, 'Kisumu'],
        'Mombasa Island' => [-4.0435, 39.6682, 'Mombasa'],
        'Nyali' => [-4.0200, 39.7000, 'Mombasa'],
        'Meru Town' => [0.0463, 37.6559, 'Meru'],
        'Machakos Town' => [-1.5177, 37.2634, 'Machakos'],
        'Kajiado Town' => [-1.8520, 36.7820, 'Kajiado'],
        'Nyeri Town' => [-0.4201, 36.9476, 'Nyeri'],
        'Kakamega Town' => [0.2827, 34.7519, 'Kakamega'],
        'Eldoret' => [0.5143, 35.2698, 'Uasin Gishu'],
        'Bungoma Town' => [0.5635, 34.5606, 'Bungoma'],
        'Kitale' => [1.0157, 35.0062, 'Trans Nzoia'],
        'Malindi' => [-3.2192, 40.1169, 'Kilifi'],
        'Garissa Town' => [-0.4532, 39.6461, 'Garissa'],
        'Embu Town' => [-0.5373, 37.4575, 'Embu'],
        'Kericho Town' => [-0.3677, 35.2831, 'Kericho'],
        'Narok Town' => [-1.0851, 35.8711, 'Narok'],
        'Isiolo Town' => [0.3556, 37.5822, 'Isiolo'],
        'Homa Bay Town' => [-0.5273, 34.4571, 'Homa Bay'],
        'Migori Town' => [-1.0634, 34.4731, 'Migori'],
        'Kitui Town' => [-1.3670, 38.0100, 'Kitui'],
        'Lamu Town' => [-2.2717, 40.9020, 'Lamu'],
    ];
}

/**
 * Build map-ready case locations from welfare_reports rows.
 *
 * @return list<array{name:string,county:string,lat:float,lng:float,count:int}>
 */
function admin_case_map_points(): array
{
    $rows = db()->query(
        'SELECT county, area, COUNT(*) AS total
         FROM welfare_reports
         GROUP BY county, area
         ORDER BY total DESC'
    )->fetchAll();

    $towns = kenya_town_points();
    $centroids = kenya_county_centroids();
    $points = [];

    foreach ($rows as $row) {
        $county = trim((string) $row['county']);
        $area = trim((string) ($row['area'] ?? ''));
        $count = (int) $row['total'];
        if ($county === '' || $count < 1) {
            continue;
        }

        $lat = null;
        $lng = null;
        $name = $area !== '' ? $area : $county;

        if ($area !== '' && isset($towns[$area])) {
            [$lat, $lng] = [$towns[$area][0], $towns[$area][1]];
            $name = $area;
        } elseif (isset($centroids[$county])) {
            [$lat, $lng] = $centroids[$county];
            // Deterministic jitter so multiple areas in one county overlap with transparency.
            if ($area !== '') {
                $hash = crc32(strtolower($county . '|' . $area));
                $lat += ((($hash % 1000) / 1000) - 0.5) * 0.18;
                $lng += (((($hash / 1000) % 1000) / 1000) - 0.5) * 0.18;
                $name = $area . ', ' . $county;
            }
        } else {
            continue;
        }

        $points[] = [
            'name' => $name,
            'county' => $county,
            'lat' => round((float) $lat, 5),
            'lng' => round((float) $lng, 5),
            'count' => $count,
        ];
    }

    return $points;
}

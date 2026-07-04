<?php

namespace App\Classes;

use App\Models\Settings;

class TrackingHelper
{
    public function __construct()
    {
    }

    public function isUserOnline($updatedAt): bool
    {

        $settings = Settings::first();
        $offlineCheckType = $settings->offline_check_time_type;
        $offlineCheckTime = $settings->offline_check_time;

        $isOnline = false;
        if ($offlineCheckType == 'minutes') {
            $isOnline = strtotime($updatedAt) > strtotime('-' . $offlineCheckTime . ' minutes');
        } else {
            $isOnline = strtotime($updatedAt) > strtotime('-' . $offlineCheckTime . ' seconds');
        }

        return $isOnline;
    }


    public function getFilteredData($trackings): array
    {

        if ($trackings->count() <= 0) {
            return [];
        }

        $finalTracking = [];

        for ($i = 0; $i < $trackings->count(); $i++) {

            $tracking = $trackings[$i];

            if ($tracking->type == 'checked_in' || $tracking->type == 'checked_out') {
                $finalTracking[] = $tracking;
                continue;
            }

            if (count($finalTracking) > 0) {
                $lastRecord = $finalTracking[count($finalTracking) - 1];

                $distance = $this->GetDistance($lastRecord->latitude, $lastRecord->longitude, $tracking->latitude, $tracking->longitude);

                if ($distance < 0.002) {
                    continue;
                }
            }

            $finalTracking[] = $tracking;
        }

        return $finalTracking;
    }

    function GetDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $R = 6371; // Radius of the earth in km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $R * $c; // Distance in km
        return $d;
    }

    public function getSnappedPath($trackings): array
    {
        if (count($trackings) < 2) {
            return [];
        }

        $apiKey = env('GOOGLE_MAPS_API_KEY');
        if (!$apiKey) {
            return [];
        }

        $points = [];
        foreach ($trackings as $t) {
            if ($t->latitude && $t->longitude) {
                $points[] = ['lat' => (float)$t->latitude, 'lng' => (float)$t->longitude];
            }
        }

        if (count($points) < 2) {
            return [];
        }

        $snappedPoints = [];
        $chunkSize = 25; 
        $totalPoints = count($points);
        
        for ($i = 0; $i < $totalPoints - 1; $i += $chunkSize - 1) {
            $endIndex = min($i + $chunkSize - 1, $totalPoints - 1);
            if ($endIndex - $i < 1) {
                break;
            }

            $origin = $points[$i];
            $destination = $points[$endIndex];
            $waypoints = [];
            for ($j = $i + 1; $j < $endIndex; $j++) {
                $waypoints[] = $points[$j]['lat'] . ',' . $points[$j]['lng'];
            }

            $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $origin['lat'] . "," . $origin['lng'] . 
                   "&destination=" . $destination['lat'] . "," . $destination['lng'] . 
                   "&mode=driving&key=" . $apiKey;
            
            if (count($waypoints) > 0) {
                $url .= "&waypoints=" . implode('|', $waypoints);
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $res = curl_exec($ch);
            curl_close($ch);

            $data = json_decode($res, true);
            if (isset($data['status']) && $data['status'] === 'OK' && isset($data['routes'][0]['overview_polyline']['points'])) {
                $decoded = $this->decodePolyline($data['routes'][0]['overview_polyline']['points']);
                $snappedPoints = array_merge($snappedPoints, $decoded);
            } else {
                for ($k = $i; $k <= $endIndex; $k++) {
                    $snappedPoints[] = $points[$k];
                }
            }
        }

        return $snappedPoints;
    }

    private function decodePolyline($polyline): array
    {
        $points = [];
        $index = 0;
        $len = strlen($polyline);
        $lat = 0;
        $lng = 0;
        while ($index < $len) {
            $b = 0;
            $shift = 0;
            $result = 0;
            do {
                $b = ord($polyline[$index++]) - 63;
                $result |= ($b & 0x1f) << $shift;
                $shift += 5;
            } while ($b >= 0x20);
            $dlat = (($result & 1) ? ~($result >> 1) : ($result >> 1));
            $lat += $dlat;
            $b = 0;
            $shift = 0;
            $result = 0;
            do {
                $b = ord($polyline[$index++]) - 63;
                $result |= ($b & 0x1f) << $shift;
                $shift += 5;
            } while ($b >= 0x20);
            $dlng = (($result & 1) ? ~($result >> 1) : ($result >> 1));
            $lng += $dlng;
            $points[] = [
                'lat' => $lat * 1e-5,
                'lng' => $lng * 1e-5
            ];
        }
        return $points;
    }

    public function test(): string
    {
        return 'test';
    }
}

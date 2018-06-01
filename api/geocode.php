<?php

namespace Sapper\Api;

class Geocode {
    public static function convert($addresses) {
        $url  = 'http://www.mapquestapi.com/geocoding/v1/batch?key=' . \Sapper\Settings::get('mapquest-api-key');

        $post = [
            'locations' => [],
            'options' => [
                'maxResults' => 1,
                'thumbMaps'  => false
            ]
        ];

        foreach ($addresses as $address) {
            $post['locations'][] = [
                'city'  => $address['city'],
                'state' => $address['state']
            ];
        }

        $curl   = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));

        $response = curl_exec($curl);

        if (false !== strpos($response, 'exceeded the number of monthly transactions')) {
            $emails = explode(',', \Sapper\Settings::get('email-notifications'));

            foreach ($emails as $email) {
                $email = trim($email);

                \Sapper\Mail::send(
                    'admin-notification',
                    ['noreply@sappersuite.com', 'Sapper Suite'],
                    [$email, $email],
                    'MapQuest Transactions Exceeded',
                    [
                        'context'   => 'MapQuest Geo-encode',
                        'exception' => $response
                    ]
                );
            }
            throw new \Exception ('MapQuest credits exceeded');
        }

        $response = json_decode($response, true);

        if (null !== $response && array_key_exists('results', $response) && is_array($response)) {
            foreach ($response['results'] as $i => $result){
                if (strtolower($addresses[$i]['state']) == strtolower($result['locations'][0]['adminArea3'])) {
                    $addresses[$i]['geolocated'] = true;
                    $addresses[$i]['lat']        = $result['locations'][0]['latLng']['lat'];
                    $addresses[$i]['lng']        = $result['locations'][0]['latLng']['lng'];
                } else {
                    $addresses[$i]['geolocated'] = false;
                    $addresses[$i]['lat']        = '';
                    $addresses[$i]['lng']        = '';
                }
            }
        }

        return $addresses;
    }

    public static function convertOne($address) {
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&key=' .
                \Sapper\Settings::get('google-maps-api-key');

        $data = json_decode(file_get_contents($url), true);

        if (is_array($data) && 'OK' == $data['status']) {
            return [
                'geolocated' => true,
                'lat'        => $data['results'][0]['geometry']['location']['lat'],
                'lng'        => $data['results'][0]['geometry']['location']['lng']
            ];
        } else {
            return ['geolocated' => false];
        }
    }
}
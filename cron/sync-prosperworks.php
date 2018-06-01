<?php

if (php_sapi_name() != 'cli') {
    die('This script can only be executed from command line');
}

require_once(__DIR__ . '/../init.php');

use Sapper\Api\ProsperworksProvider;
use Sapper\Db;
use Sapper\Util;

set_time_limit(0);

$prosperworksProvider = ProsperworksProvider::getInstance();

$continue = true;
$page = 1;

// Rate limit is 600 per 10 minutes, so we should be fine
while ($continue) {
    $companies = $prosperworksProvider->getCompanies($page);

    foreach ($companies as $company) {

        $customFields = [];

        // translate custom fields
        if (array_key_exists('custom_fields', $company)) {
            foreach ($company['custom_fields'] as $i => $fieldData) {

                if (!empty($fieldData['custom_field_definition_id']) && !empty($fieldData['value'])) {

                    list($name, $value) = $prosperworksProvider->translateCustomDefinition(
                        $fieldData['custom_field_definition_id'], $fieldData['value']
                    );

                    if ($name && $value) {
                        $customFields[$name] = $value;
                    }
                }
            }
        }

        $existing = Db::fetch(
            'SELECT * FROM `sap_client_prosperworks` WHERE `prosperworks_ext_id` = :id',
            ['id' => $company['id']]
        );

        $fields = [
            'prosperworks_ext_id'  => Util::val($company, ['id']),
            'name'                 => Util::val($company, ['name']),
            'street'               => Util::val($company, ['address', 'street']),
            'city'                 => Util::val($company, ['address', 'city']),
            'state'                => Util::val($company, ['address', 'state']),
            'postal_code'          => Util::val($company, ['address', 'postal_code']),
            'country'              => Util::val($company, ['address', 'country']),
            'company_revenue'      => Util::val($customFields, ['Company Revenue', 'name']),
            'number_of_employees'  => Util::val($customFields, ['# of Employees', 'name']),
            'company_age'          => Util::val($customFields, ['Company Age', 'name']),
            'industry'             => Util::val($customFields, ['Industry', 'name']),
            'last_meeting_booked'  => Util::val($customFields, ['Last Meeting Booked', 'name'])
        ];

        if ($existing) {
            Db::updateRowById('client_prosperworks', $existing['id'], $fields);
        } else {
            Db::createRow('client_prosperworks', $fields);
        }

        print '.';
    }

    if (count($companies) == ProsperworksProvider::RESULTS_PER_QUERY) {
        $page ++;
    } else {
        $continue = false;
    }
}

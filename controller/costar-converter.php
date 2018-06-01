<?php

use Sapper\Db,
    Sapper\User;

// permissions
if (!User::can('normalize-costar-files')) {
    sapperView('error', ['title' => 'Oops!', 'message' => 'You do not have permission to access this feature.']);
}

if ('POST' == $_SERVER['REQUEST_METHOD']) {

    // load models
    $states  = Model::get('states');

    // set dir & filenames
    $path = 'upload/' . date('Y-m-d');
    if (!is_dir($path)) {
        mkdir($path);
    }

    $filename = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
    $filteredSuffix = ' (Filtered).csv';

    if (!file_exists($path . '/' . $filename . $filteredSuffix)) {
        $filteredFile = $filename . $filteredSuffix;
    } else {
        $i = 1;
        while (file_exists($path . '/' . $filename . " ($i) " . $filteredSuffix)) {
            $i++;
        }
        $filteredFile = $filename . " ($i) " . $filteredSuffix;
    }

    $outputHeaders = ['Name', 'Email', 'State', 'Title'];

    // filtered output
    $output = fopen($path . '/' . $filteredFile, 'w');
    fputcsv($output, $outputHeaders);

    $objPHPExcel = PHPExcel_IOFactory::load($_FILES['file']['tmp_name']);

    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

    $rowCount  = 0;

    foreach ($sheetData as $row) {
        if (0 === strpos($row['A'], 'Contact Name')) {
            continue;
        }

        // name
        $matches = [];
        preg_match('/(.*)\n.*/', $row['A'], $matches);

        if (array_key_exists(1, $matches)) {
            $name = $matches[1];
        } else {
            $name = $row['A'];
        }

        // email
        $matches = [];
        $email = '';
        foreach (['L', 'O', 'M', 'N'] as $column) {
            preg_match('/(\S+@[^\s\.]+\.\S+)/', $row[$column], $matches);
            if (count($matches) > 0) {
                $email = $matches[1];
                break;
            }
        }

        // state
        $matches = [];
        $state   = '';
        foreach (['F', 'D', 'G', 'B', 'J'] as $column) {
            foreach ($states as $stateCode => $stateName) {
                if (false !== strpos($row[$column], ' ' . $stateCode . ' ') ||
                    false !== strpos($row[$column], ' ' . $stateName . ' ')
                ) {
                    $state = $stateCode;
                    break 2;
                }
            }
        }

        // title
        $matches = [];
        $titles = [
            'Landlord Rep',
            'Property Manager',
            'Previous True Owner',
            'True Owner',
            'Survey Contact',
            'Sublet Contact',
            'Developer',
            'Previous Recorded Owner',
            'Listing Broker',
            'Recorded Owner',
            'Specialty Leasing Manager',
            'Architect',
            'Center Mail Contact',
            'Asset Manager'
        ];
        $title = '';
        foreach (['O', 'L', 'N', 'M'] as $column) {
            foreach ($titles as $titleMatch) {
                if (false !== strpos($row[$column], $titleMatch)) {
                    $title = $titleMatch;
                    break 2;
                }
            }
        }

        if (!empty($email)) {
            fputcsv($output, [$name, $email, $state, $title]);
            $rowCount++;
        }
    }

    fclose($output);

    $id = Db::insert(
        'INSERT INTO `sap_download`
              (`created_on`, `filename`, `row_count`, `filtered`, `filtered_count`, `purged`, `purged_count`)
         VALUES (:created_on, :filename, :row_count, :filtered, :filtered_count, :purged, :purged_count)',
        [
            'created_on'     => date('Y-m-d'),
            'filename'       => $filename,
            'row_count'      => $rowCount,
            'filtered'       => $filteredFile,
            'filtered_count' => $rowCount,
            'purged'         => '',
            'purged_count'   => 0
        ]
    );

    header('Location: /downloads/' . $id);
    exit;
}

sapperView('costar-converter');
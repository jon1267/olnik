<?php

namespace App\Services\Import;

class Csv {

    public static function parseCsv($filename, $delimiter = ',')
    {
        $header = null;
        $data = [];
        $seed = [];
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        if(is_array($data) && count($data)) {
            foreach ($data as $k1 => $v1)
                foreach($v1 as $k2 => $v2)
                    $seed[$k1][strtolower($k2)] = $v2;
        }

        return $seed;
    }
}
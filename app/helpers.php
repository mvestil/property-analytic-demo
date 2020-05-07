<?php

if (!function_exists('parseCSV')) {
    function parseCSV(string $filePath, Closure $fn)
    {
        if (($file = fopen($filePath, 'r')) !== false) {
            // skip the first line which is the header
            fgetcsv($file, 0, ',');

            while (($data = fgetcsv($file, 0, ',')) !== false) {
                $fn($data);
            }

            fclose($file);
        }
    }
}

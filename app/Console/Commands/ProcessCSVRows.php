<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use ZipArchive;

class ProcessCSVRows extends Command
{
    protected $signature = 'csv:process {file}';

    protected $description = 'Read a CSV file, create a Word file for each row, and download all files as a zip';

    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error('The specified file does not exist.');
            return;
        }

        $file = fopen($filePath, 'r');

        $header = fgetcsv($file);

        // Define the mapping for column names in the CSV file
        $mapping = [
            'First Name' => 'First Name',
            'Last Name' => 'Last Name',
            'Email' => 'Email',
            'Email Address1' => 'Email Address1',
            'Mobile Number' => 'Mobile Number',
            'Home Phone Number' => 'Home Phone Number',
            'Job Title' => 'Job Title',
            'Postal Code' => 'Postal Code',
            'Address' => 'Address',
            'Country' => 'Country',
            'State' => 'State',
            'City' => 'City',
            'DND' => 'DND',
            'Skills' => 'Skills',
            'Communication status' => 'Communication status',
            'Document' => 'Document'
        ];

        $batchSize = 1000; // Number of Word files to save in each batch
        $batchCount = 0;
        $wordFiles = [];

        while (($row = fgetcsv($file)) !== false) {
            if (count($header) !== count($row)) {
                $this->warn('Skipping row: Header and row have different lengths.');
                continue;
            }

            $rowData = array_combine($header, $row);

            // Map the array keys using the provided mapping
            $mappedRowData = [];
            foreach ($mapping as $columnKey => $arrayKey) {
                $mappedRowData[$arrayKey] = $rowData[$columnKey];
            }

            $wordFile = $this->createWordFile($mappedRowData);
            $wordFiles[] = $wordFile;

            if (count($wordFiles) >= $batchSize) {
                $this->saveWordFiles($wordFiles, $batchCount);
                $wordFiles = [];
                $batchCount++;
            }
        }

        // Save the remaining word files
        if (!empty($wordFiles)) {
            $this->saveWordFiles($wordFiles, $batchCount);
        }

        fclose($file);

        $this->info('Processing completed.');

        $zipPath = sys_get_temp_dir() . '/word_files_' . uniqid() . '.zip'; // Unique zip file name
        $this->createZipFile($zipPath, $batchCount);

        $this->info('Zip file created: ' . $zipPath);
        $this->info('Downloading the zip file...');

        $this->downloadZipFile($zipPath);
    }

    private function createWordFile(array $rowData)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
         if (!empty($rowData['First Name'])) {
            $section->addText($rowData['First Name']);
        }
        if (!empty($rowData['Last Name'])) {
            $section->addText($rowData['Last Name']);
        }
        if (!empty($rowData['Email'])) {
            $section->addText($rowData['Email']);
        }
        if (!empty($rowData['Email Address1'])) {
            $section->addText($rowData['Email Address1']);
        }
        if (!empty($rowData['Mobile Number'])) {
            $section->addText($rowData['Mobile Number']);
        }
        if (!empty($rowData['Home Phone Number'])) {
            $section->addText($rowData['Home Phone Number']);
        }
        if (!empty($rowData['Job Title'])) {
            $section->addText($rowData['Job Title']);
        }
        if (!empty($rowData['Postal Code'])) {
            $section->addText($rowData['Postal Code']);
        }
        if (!empty($rowData['Address'])) {
            $section->addText($rowData['Address']);
        }
        if (!empty($rowData['Country'])) {
            $section->addText($rowData['Country']);
        }
        if (!empty($rowData['State'])) {
            $section->addText($rowData['State']);
        }
        if (!empty($rowData['City'])) {
            $section->addText($rowData['City']);
        }
        if (!empty($rowData['DND'])) {
            $section->addText($rowData['DND']);
        }
        if (!empty($rowData['Skills'])) {
            $section->addText($rowData['Skills']);
        }

        $filename = $rowData['Document'];
        $savePath = sys_get_temp_dir() ."/".  $filename ; // Unique Word file name
        $phpWord->save($savePath);

        return $savePath;
    }

    private function saveWordFiles(array $wordFiles, int $batchCount)
    {
        $batchDirectory = sys_get_temp_dir() . '/batch_' . $batchCount;
        if (!file_exists($batchDirectory)) {
            mkdir($batchDirectory, 0777, true);
        }

        foreach ($wordFiles as $filePath) {
            $filename = basename($filePath);
            $targetFile = $batchDirectory . '/' . $filename;
            copy($filePath, $targetFile);
        }
    }

    private function createZipFile(string $zipPath, int $batchCount)
    {
        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            $this->error('Failed to create zip file.');
            return;
        }

        $batchDirectory = sys_get_temp_dir();

        for ($i = 0; $i <= $batchCount; $i++) {
            $batchFiles = glob($batchDirectory . '/batch_' . $i . '/*');
            foreach ($batchFiles as $file) {
                $zip->addFile($file, basename($file));
            }
        }

        $zip->close();
    }

    private function downloadZipFile(string $zipPath)
    {
        $zipFilename = basename($zipPath);

        $response = response()->download($zipPath, $zipFilename)->deleteFileAfterSend(true);

        while (ob_get_level()) {
            ob_end_clean();
        }

        $response->send();
        exit;
    }
}

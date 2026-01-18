<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Smalot\PdfParser\Parser as PdfParser;
use Storage;

use App\Models\Library\LibraryMaterial;

class ProjectUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project-update:manage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the project based on given situations.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->eLibraryPdfPagesUpdate();
        // return 0;
        
    }

    private function eLibraryPdfPagesUpdate()
    {
        print("\n--------------------------------");
        $total = LibraryMaterial::where('type', 'file')
            ->where(function ($query) {
                $query->whereNull('pages')
                    ->orWhere('pages', '<=', 0);
            })
            ->count();
        print("\nTotal e-Library PDF materials to update: " . $total);
        print("\n");

        $storage = Storage::disk('public');

        $materials = LibraryMaterial::where('type', 'file')
            ->where(function ($query) {
                $query->whereNull('pages')
                    ->orWhere('pages', '<=', 0);
            })
            ->take(20)
            ->get(['id','fileurl','pages']);

        $bar = $this->output->createProgressBar($materials->count());
        $bar->start();

        foreach ($materials as $material) {
            $pdfPath = $storage->path($material->fileurl);
            if (file_exists($pdfPath)) {
                try {
                    $parser = new PdfParser();
                    $pdf = $parser->parseFile($pdfPath);
                    $pageCount = count($pdf->getPages());

                    $material->update(['pages' => $pageCount]);

                } catch (\Throwable $e) {
                    // throw $e;
                }            
            }
            print("\nCompleted ID: ".$material->id."\n");

            $bar->advance();
        }

        $bar->finish();
        print("\nCompleted e-Library PDF pages update.");
        print("\n--------------------------------\n");
        
        return 0;
    }


}

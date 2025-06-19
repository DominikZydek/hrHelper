<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Carbon\Carbon;

class ArchiveExpiredFiles extends Command
{
    protected $signature = 'files:archive-expired {--debug : Enable debug mode}';
    protected $description = 'Archive files after date_to and remove from archive after date_archive';

    public function handle()
    {
        $this->info('Starting file archival process...');
        $debug = $this->option('debug');
        $currentDate = Carbon::now();

        if ($debug) {
            $this->info("Current date: " . $currentDate->format('Y-m-d H:i:s'));
        }

        // step 1: move files to archive after date_to expires
        $this->moveToArchive($debug, $currentDate);

        // step 2: remove files from archive after date_archive expires
        $this->removeFromArchive($debug, $currentDate);

        return 0;
    }

    private function moveToArchive($debug, $currentDate)
    {
        $this->info('=== STEP 1: Moving expired files to archive ===');

        // find active files (not in archive) where date_to has passed
        $expiredFiles = Media::whereNotNull('custom_properties->date_to')
            ->where('collection_name', '!=', 'archive')
            ->get()
            ->filter(function ($media) use ($currentDate, $debug) {
                $dateTo = $media->getCustomProperty('date_to');

                if (!$dateTo) {
                    return false;
                }

                try {
                    $parsedDateTo = Carbon::parse($dateTo);
                    $isExpired = $parsedDateTo->lt($currentDate);

                    if ($debug) {
                        $this->info("File: {$media->name}");
                        $this->info("  date_to: " . $parsedDateTo->format('Y-m-d H:i:s'));
                        $this->info("  expired: " . ($isExpired ? 'YES' : 'NO'));
                    }

                    return $isExpired;
                } catch (\Exception $e) {
                    if ($debug) {
                        $this->error("  Failed to parse date_to '{$dateTo}': " . $e->getMessage());
                    }
                    return false;
                }
            });

        $movedToArchive = 0;
        $failedToArchive = 0;

        foreach ($expiredFiles as $media) {
            try {
                if ($debug) {
                    $this->info("Moving to archive: {$media->name}");
                }

                // check if model exists
                if (!$media->model) {
                    $this->error("  No model associated with media {$media->id}");
                    $failedToArchive++;
                    continue;
                }

                // move to archive collection
                $media->move($media->model, 'archive');

                $this->info("✓ Moved to archive: {$media->name}");
                $movedToArchive++;
            } catch (\Exception $e) {
                $this->error("✗ Failed to move {$media->name} to archive: " . $e->getMessage());
                $failedToArchive++;
            }
        }

        $this->info("Moved to archive: {$movedToArchive} files");
        if ($failedToArchive > 0) {
            $this->warn("Failed to move to archive: {$failedToArchive} files");
        }
    }

    private function removeFromArchive($debug, $currentDate)
    {
        $this->info('=== STEP 2: Removing files from archive after date_archive ===');

        // find files in archive where date_archive has passed
        $expiredArchiveFiles = Media::whereNotNull('custom_properties->date_archive')
            ->where('collection_name', 'archive')
            ->get()
            ->filter(function ($media) use ($currentDate, $debug) {
                $dateArchive = $media->getCustomProperty('date_archive');

                if (!$dateArchive) {
                    return false;
                }

                try {
                    $parsedDateArchive = Carbon::parse($dateArchive);
                    $shouldRemove = $parsedDateArchive->lt($currentDate);

                    if ($debug) {
                        $this->info("Archive file: {$media->name}");
                        $this->info("  date_archive: " . $parsedDateArchive->format('Y-m-d H:i:s'));
                        $this->info("  should remove: " . ($shouldRemove ? 'YES' : 'NO'));
                    }

                    return $shouldRemove;
                } catch (\Exception $e) {
                    if ($debug) {
                        $this->error("  Failed to parse date_archive '{$dateArchive}': " . $e->getMessage());
                    }
                    return false;
                }
            });

        $removedFromArchive = 0;
        $failedToRemove = 0;

        foreach ($expiredArchiveFiles as $media) {
            try {
                if ($debug) {
                    $this->info("Removing from archive: {$media->name}");
                }

                // option 1: delete completely
                $media->delete();

                // option 2: move to "deleted" collection (uncomment if preferred)
                // $media->move($media->model, 'deleted');

                $this->info("✓ Removed from archive: {$media->name}");
                $removedFromArchive++;
            } catch (\Exception $e) {
                $this->error("✗ Failed to remove {$media->name} from archive: " . $e->getMessage());
                $failedToRemove++;
            }
        }

        $this->info("Removed from archive: {$removedFromArchive} files");
        if ($failedToRemove > 0) {
            $this->warn("Failed to remove from archive: {$failedToRemove} files");
        }

        // summary
        if ($debug) {
            $totalInArchive = Media::where('collection_name', 'archive')->count();
            $this->info("Total files remaining in archive: {$totalInArchive}");
        }
    }
}

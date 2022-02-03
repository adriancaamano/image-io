<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class UploadImages extends Component
{
    use WithFileUploads;

    public $photos = [];
    public $additional_photos = [];
    public $width = [];
    public $output = 'webp';
    public $compression = 90;

    public function render()
    {
        return view('livewire.upload-images');
    }

    public function updatedPhotos()
    {
        $this->validate([
            'photos.*' => 'image|max:5120', // 1MB Max
        ]);
    }

    public function updatedAdditionalPhotos()
    {
        $this->validate([
            'additional_photos.*' => 'image|max:5120', // 1MB Max
        ]);

        $this->photos = array_merge($this->photos, $this->additional_photos);

        $this->additional_photos = [];
    }
    
    public function save()
    {
        $newImages = [];

        $folder = 'conversion' . '/' . Str::uuid()->toString();
        
        if(\Storage::disk('local')->makeDirectory($folder)) {
            $output_path = storage_path('app/' . $folder);

            foreach($this->photos as $photo) {
                $newImages[] = $this->generateImage($photo, $output_path, $this->output, $this->compression);

                foreach($this->width as $width) {
                    $newImages[] = $this->generateImage($photo, $output_path, $this->output, $this->compression, $width);
                }
            }

            return $this->compressFiles($newImages, $output_path);
        }
    }

    public function delete($index)
    {
        $this->photos[$index]->delete();

        unset($this->photos[$index]);
    }

    protected function generateImage($input, $output_path, $output_type, $compression_quality, $width = 0) 
    {
        $name = Str::slug(pathinfo($input->getClientOriginalName(), PATHINFO_FILENAME), '_');
        $file_type = Str::slug(pathinfo($input->getRealPath(), PATHINFO_EXTENSION), '_');

        if($width) {
            $name .= '-'.$width;
        }

        // If output file already exists return path
        $output_file = $output_path . '/' . $name . '.' . $output_type;

        if (file_exists($output_file)) {
            return $output_file;
        }

        if (class_exists('Imagick')) {
            $image = new \Imagick();
            $image->readImage($input->getRealPath());
            $image->setImageFormat($output_type);
            $image->setCompressionQuality($compression_quality);

            if($width) {
                $image->scaleImage($width, 0);
            }

            if ($output_type == 'webp') {
                $image->setOption('webp:method', '6'); 
                // $image->setOption('webp:lossless', 'true');
            }

            $image->writeImage($output_file);

            return $output_file;
        }

        return false;
    }

    protected function compressFiles($files, $output_path)
    {
        $zip_file = $output_path . '/' . 'images.zip';

        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        
        foreach($files as $file) {
            $name = strtolower(pathinfo($file, PATHINFO_FILENAME));
            $file_type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            $zip->addFile($file, $name . '.' . $file_type);
        }
        
        $zip->close();
        
        // We return the file immediately after download
        return response()->download($zip_file);
    }
}

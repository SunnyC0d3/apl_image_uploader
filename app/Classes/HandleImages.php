<?php

namespace App\Classes;

use App\Models\Image;
use App\Models\StorageSetting;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image as ImageResizer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\ImageManager;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class HandleImages
{
    private $storageMode;
    private $imageManager;

    /**
     * Constructor to initialize storage mode and ImageManager instance.
     */
    public function __construct(ImageManager $imageManager)
    {
        $this->storageMode = StorageSetting::getMode();
        $this->imageManager = $imageManager;
    }

    /**
     * Retrieve images based on the configured storage mode.
     */
    public function images()
    {
        if ($this->storageMode === 'local') {
            return $this->getLocalImages();
        } else {
            return $this->getAzureImages();
        }
    }

    /**
     * Upload an image to the configured storage.
     *
     * @param object $file Uploaded file instance.
     */
    public function upload(object $file)
    {
        $filename = time() . '.' . $file->getClientOriginalExtension();

        $image = $this->imageManager->read($file);
        $this->checkImageDimensions($image);
        $formattedImage = $this->fileFormat($file, $image);

        if ($this->storageMode === 'azure') {
            Storage::disk('azure')->put($filename, (string) $formattedImage);
            $path = Storage::disk('azure')->url($filename);
        } else {
            $path = 'uploads/' . $filename;
            Storage::disk('public')->put($path, (string) $formattedImage);
        }

        Image::create([
            'filename' => $filename,
            'path' => $path,
            'width' => $image->width(),
            'height' => $image->height(),
            'storage_driver' => $this->storageMode
        ]);
    }

    /**
     * Update an existing image in storage.
     *
     * @param object $file New uploaded file instance.
     * @param string $oldFilename Existing filename to replace.
     */
    public function update(object $file, string $oldFilename)
    {
        $filename = time() . '.' . $file->getClientOriginalExtension();

        $image = $this->imageManager->read($file);
        $this->checkImageDimensions($image);
        $formattedImage = $this->fileFormat($file, $image);

        if ($this->storageMode === 'azure') {
            Storage::disk('azure')->delete(Storage::disk('azure')->url($oldFilename));
            Storage::disk('azure')->put($filename, (string) $formattedImage);
            $path = Storage::disk('azure')->url($filename);

            $image = Image::where('filename', $oldFilename)
                ->update([
                    'filename' => $filename,
                    'path' => $path,
                    'width' => $image->width(),
                    'height' => $image->height(),
                    'storage_driver' => $this->storageMode
                ]);
        } else {
            $path = 'uploads/' . $filename;
            $image = Image::where('filename', $oldFilename)
                ->update([
                    'filename' => $filename,
                    'path' => $path,
                    'width' => $image->width(),
                    'height' => $image->height(),
                    'storage_driver' => $this->storageMode
                ]);

            Storage::disk('public')->delete('uploads/' . $oldFilename);
            Storage::disk('public')->put($path, (string) $formattedImage);
        }
    }

    /**
     * Delete an image from storage.
     *
     * @param string $filename Name of the file to be deleted.
     */
    public function delete(string $filename)
    {
        if ($this->storageMode === 'azure') {
            Storage::disk('azure')->delete(Storage::disk('azure')->url($filename));
        } else {
            Storage::disk('public')->delete('uploads/' . $filename);
        }
    }

    /**
     * Retrieve the URL of a stored image.
     *
     * @param string $filename Image filename.
     * @throws NotFoundHttpException If the image does not exist.
     */
    public function getImageUrl(string $filename)
    {
        if ($this->storageMode === 'local') {
            $dir = storage_path('app/public/uploads');
            $localPath = "{$dir}/{$filename}";

            if (!file_exists($localPath)) {
                throw new NotFoundHttpException('Image not found.');
            }

            return $this->formatImageOutput($filename, $localPath);
        }

        if ($this->storageMode === 'azure') {
            if (!Storage::disk('azure')->exists($filename)) {
                throw new NotFoundHttpException('Image not found.');
            }

            $path = Storage::disk('azure')->url($filename);
            return $this->formatImageOutput($filename, $path);
        }

        return throw new NotFoundHttpException('Image not found.');
    }

    /**
     * Format image output details to jpg/png.
     */
    private function fileFormat(object $file, ImageInterface $image)
    {
        return $file->getClientOriginalExtension() === 'jpg' || $file->getClientOriginalExtension() === 'jpeg' ? $image->toJpeg(90) : $image->toPng(indexed: true);
    }

    /**
     * Format image output details.
     */
    private function formatImageOutput(string $filename, string $path)
    {
        if ($this->storageMode === 'local') {
            list($width, $height) = getimagesize($path);
            $createdAt = date('Y-m-d H:i:s', filectime($path));
            $updatedAt = date('Y-m-d H:i:s', filemtime($path));
        } else {
            $width = null;
            $height = null;
            $createdAt = null;
            $updatedAt = null;
        }

        return [
            'name' => $filename,
            'path' => $this->storageMode === 'local' ? asset("storage/uploads/$filename") : $path,
            'width' => $width,
            'height' => $height,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    /**
     * Ensure uploaded image dimensions do not exceed 1024x1024.
     */
    private function checkImageDimensions(ImageInterface $image)
    {
        if ($image->width() > 1024 || $image->height() > 1024) {
            throw new Exception('Image dimensions should not exceed 1024x1024.');
        }
    }

    /**
     * Retrieve paginated images.
     */
    private function getPaginatedImages($images)
    {
        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $totalItems = $images->count();
        $currentItems = $images->forPage($currentPage, $perPage);

        $paginator = new LengthAwarePaginator(
            $currentItems,
            $totalItems,
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );

        return $paginator;
    }

    /**
     * Retrieve images stored locally and paginate the results.
     *
     * @return LengthAwarePaginator
     */
    private function getLocalImages()
    {
        $dir = storage_path('app/public/uploads');

        if (!is_dir($dir)) {
            return collect([]);
        }

        return $this->getPaginatedImages(
            collect(scandir($dir))
                ->filter(fn($image) => in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'png']))
                ->map(function ($image) use ($dir) {
                    $imagePath = $dir . DIRECTORY_SEPARATOR . $image;
                    return $this->formatImageOutput($image, $imagePath);
                })
        );
    }

    /**
     * Retrieve images stored on Azure and paginate the results.
     *
     * @return LengthAwarePaginator
     */
    private function getAzureImages()
    {
        $azureDisk = Storage::disk('azure');

        $files = $azureDisk->files('/');

        if (empty($files)) {
            return collect([]);
        }

        return $this->getPaginatedImages(
            collect($files)
                ->filter(fn($file) => in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'png']))
                ->map(function ($file) use ($azureDisk) {
                    return $this->formatImageOutput(basename($file), $azureDisk->url($file));
                })
        );
    }
}

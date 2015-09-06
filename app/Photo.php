<?php

namespace App;

use Image;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends Model
{
    /**
     * The associated table.
     * 
     * @var string
     */
    protected $table = 'flyer_photos';

    /**
     * Fillable fields for a photo.
     * 
     * @var array
     */
    protected $fillable = ['path', 'name', 'thumbnail_path'];

    /**
     * The UploadedFile instance.
     * 
     * @var UploadedFile
     */
    protected $file;

    /**
     * When a photo is created, prepare a thumbnail too.
     * 
     * @return void
     */
    protected static function boot()
    {
        static::creating(function ($photo) {
            return $photo->upload();
        });
    }

    /**
     * A photo belongs to a flyer.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flyer()
    {
        return $this->belongsTo('App\Flyer');
    }

    /**
     * Make a photo instance from an uploaded file.
     * 
     * @param  UploadedFile $file
     * @return self
     */
    public static function fromFile(UploadedFile $file)
    {
        $photo = new static;

        $photo->file = $file;

        return $photo->fill([
            'name' => $photo->fileName(),
            'path' => $photo->filePath(),
            'thumbnail_path' => $photo->thumbnailPath()
        ]);
    }

    /**
     * Get the base directory for photo uploads.
     * 
     * @return string
     */
    public function baseDir()
    {
        return 'images/photos';
    }

    /**
     * Get the file name for a photo.
     * 
     * @return string
     */
    public function fileName()
    {
        $name = sha1(
            time() . $this->file->getClientOriginalName()
        );

        $extension = $this->file->getClientOriginalExtension();

        return "{$name}.{$extension}";
    }

    /**
     * Get the path to the photo.
     * 
     * @return string
     */
    public function filePath()
    {
        return $this->baseDir() . '/' . $this->fileName();
    }

    /**
     * Get the path to the photo's thumbnail.
     * 
     * @return string
     */
    public function thumbnailPath()
    {
        return $this->baseDir() . '/tn-' . $this->fileName();
    }

    /**
     * Move the photo to the proper folder.
     * 
     * @return self
     */
    public function upload()
    {
       $this->file->move($this->baseDir(), $this->fileName());

       $this->makeThumbnail();

       return $this;
    }

    /**
     * Create a thumbnail for the photo.
     * 
     * @return void
     */
    protected function makeThumbnail()
    {
        Image::make($this->filePath())
        ->fit(200)
        ->save($this->thumbnailPath());
    }

    protected function saveAs($name)
    {
       $this->name = sprintf("%s-%s", time(), $name);
       $this->path = sprintf("%s/%s", $this->baseDir, $this->name);
       $this->thumbnail_path = sprintf("%s/tn-%s", $this->baseDir, $this->name);

       return $this;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends Model
{

    protected $table = 'flyer_photos';

    protected $fillable = ['path'];

    protected $baseDir = 'flyers/photos';

    /**
     * A flyer is composed of many photos.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flyer()
    {
        return $this->belongsTo('App\Flyer');
    }

    /**
     * Format the name of the incoming file upload.
     * 
     * @param  UploadedFile $file
     * @return string|null $photo
     */
    public static function fromForm(UploadedFile $file)
    {
        $photo = new static;

        $name = time() . $file->getClientOriginalName();

        $photo->path = $photo->baseDir . '/' . $name;

        $file->move($photo->baseDir, $name);

        return $photo;
    }

    
    protected function saveAs($name)
    {
       // $this->name = sprintf("%s-%s", time(), $name);
       // $this->path = sprintf("%s/%s", $this->baseDir, $this->name);
       // $this->thumbnail_path = sprintf("%s/tn-%s", $this->baseDir, $this->name);

       // return $this;
    }

    
    public function move(UploadedFile $file)
    {
       $file->move($this->baseDir, $this->name);

       // $this->makeThumbnail();

       return $this;
    }

    
    public function makeThumbnail()
    {
       // Image::make($this->path)
       //         ->fit(200)
       //         ->save($this->thumbnail_path);

      //  return $this;
    }
}

<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Concerns;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasProfilePhoto
{


    public function profilePhoto()
    {
        return  $this->getAttribute('cover');
    }

    public function getProfilePhotoFieldName()
    {
        return 'cover';
    } 
    /**
     * Update the user's profile photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @param  string  $storagePath
     * @return void
     */
    public function updateProfilePhoto(UploadedFile $photo, $storagePath = 'profile-photos')
    {
        tap($this->profilePhoto(), function ($previous) use ($photo, $storagePath) {
            $data[$this->getProfilePhotoFieldName()] = $photo->storePublicly($storagePath, ['disk' => $this->profilePhotoDisk()]); 
            $this->forceFill($data)->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {

        if (is_null($this->profilePhoto())) {
            return;
        }

        Storage::disk($this->profilePhotoDisk())->delete($this->profilePhoto());

        $data[$this->getProfilePhotoFieldName()] = null;
        $this->forceFill($data)->save();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function profilePhotoUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return $this->profilePhoto()
                ? Storage::disk($this->profilePhotoDisk())->url($this->profilePhoto())
                : $this->defaultProfilePhotoUrl();
        });
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultProfilePhotoUrl()
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function profilePhotoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('acl.profile_photo_disk', 'public');
    }
}

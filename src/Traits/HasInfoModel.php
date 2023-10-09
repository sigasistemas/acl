<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Traits;

use Callcocam\Acl\Models\Address;
use Callcocam\Acl\Models\Contact;
use Callcocam\Acl\Models\Document;
use Callcocam\Acl\Models\Image;
use Callcocam\Acl\Models\Social;

trait HasInfoModel
{
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function contacts()
    {
        return $this->morphMany(Contact::class, 'contactable');
    }

    public function socials()
    {
        return $this->morphMany(Social::class, 'socialable');
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class SeoField extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'route', 'name_route', 'meta_title', 'meta_keywords', 'meta_description', 'meta_robot', 'canonical_url', 'custom_url', 'json_ld', 'og_title', 'og_description', 'og_image'
    ];

    /**
     * Get the column names of the table.
     *
     * @return array
     */
    public static function getColumnNames()
    {
        return Schema::getColumnListing((new self)->getTable());
    }
}

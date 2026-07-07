<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $link
 * @property string|null $category
 * @property string|null $thumbnail
 * @property bool $is_active
 * @property int $order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class SourceCode extends Model
{
    /**
     * The resource name for this model when it is transformed into an
     * API representation.
     */
    public const RESOURCE_NAME = 'source_code';

    /**
     * The table associated with the model.
     */
    protected $table = 'source_codes';

    /**
     * Fields that are not mass assignable.
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Rules ensuring that the raw data stored in the database meets expectations.
     */
    public static array $validationRules = [
        'title' => 'required|string|between:1,191',
        'description' => 'nullable|string|max:2000',
        'link' => 'required|url|max:500',
        'category' => 'nullable|string|max:100',
        'thumbnail' => 'nullable|url|max:500',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    protected $attributes = [
        'is_active' => true,
        'order' => 0,
    ];

    /**
     * Attributes that should be cast to a specific type.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}

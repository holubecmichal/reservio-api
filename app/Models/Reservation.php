<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @mixin Builder
 */
class Reservation extends Model
{
    use HasFactory;

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'user_id',
        'start_at',
        'end_at',
        'description',
    ];

    /**
     * @inheritDoc
     */
    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * ID getter.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * User ID getter.
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * User relationship.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Start at getter.
     */
    public function getStartAt(): Carbon
    {
        return $this->start_at;
    }

    /**
     * End at getter.
     */
    public function getEndAt(): Carbon
    {
        return $this->end_at;
    }

    /**
     * Description getter.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Created at getter.
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * Updated at getter.
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }
}

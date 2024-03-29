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
     * User getter.
     */
    public function getUser(): User
    {
        return $this->user;
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

    /**
     * Scope by start at.
     */
    public static function scopeStartAtRange(Builder $builder, ?string $dateFrom = null, ?string $dateTo = null): void
    {
        if ($dateFrom !== null) {
            $builder->where('start_at', '>=', $dateFrom);
        }

        if ($dateTo !== null) {
            $builder->where('start_at', '<=', $dateTo);
        }
    }

    /**
     * Scope by end at.
     */
    public static function scopeEndAtRange(Builder $builder, ?string $dateFrom = null, ?string $dateTo = null): void
    {
        if ($dateFrom !== null) {
            $builder->where('end_at', '>=', $dateFrom);
        }

        if ($dateTo !== null) {
            $builder->where('end_at', '<=', $dateTo);
        }
    }
}

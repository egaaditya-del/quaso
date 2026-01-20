<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model
{
    protected $fillable = [
        'name',
        'email',
        'birth_date',
        'gender',
        'address',
        'phone',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the parents of this family member
     */
    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(
            Family::class,
            'family_relationships',
            'child_id',
            'parent_id'
        )
        ->withPivot('relationship_type')
        ->withTimestamps();
    }

    /**
     * Get the children of this family member
     */
    public function children(): BelongsToMany
    {
        return $this->belongsToMany(
            Family::class,
            'family_relationships',
            'parent_id',
            'child_id'
        )
        ->withPivot('relationship_type')
        ->withTimestamps();
    }

    /**
     * Get the spouse of this family member
     */
    public function spouse(): BelongsToMany
    {
        return $this->belongsToMany(
            Family::class,
            'family_relationships',
            'parent_id',
            'child_id'
        )
        ->wherePivot('relationship_type', 'Suami')
        ->orWherePivot('relationship_type', 'Istri')
        ->withTimestamps();
    }

    /**
     * Get all family relationships where this member is the parent
     */
    public function parentRelationships(): HasMany
    {
        return $this->hasMany(FamilyRelationship::class, 'parent_id');
    }

    /**
     * Get all family relationships where this member is the child
     */
    public function childRelationships(): HasMany
    {
        return $this->hasMany(FamilyRelationship::class, 'child_id');
    }

    /**
     * Get the age of the family member
     */
    public function getAgeAttribute(): ?int
    {
        if (!$this->birth_date) {
            return null;
        }

        return $this->birth_date->diffInYears(now());
    }

    /**
     * Scope to filter by gender
     */
    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    /**
     * Scope to filter by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}

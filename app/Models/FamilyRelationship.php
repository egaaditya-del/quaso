<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyRelationship extends Model
{
    protected $table = 'family_relationships';

    protected $fillable = [
        'parent_id',
        'child_id',
        'relationship_type',
    ];

    public function parent()
    {
        return $this->belongsTo(Family::class, 'parent_id');
    }

    public function child()
    {
        return $this->belongsTo(Family::class, 'child_id');
    }
}

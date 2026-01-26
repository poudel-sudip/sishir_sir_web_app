<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['total_materials', 'active_materials'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($cat){
            $slug = Str::slug($cat->name);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $cat->slug = $count ? "{$slug}-{$count}" : $slug;
        });

        static::saved(fn ($m) => Cache::flush());
        static::deleted(fn ($m) => Cache::flush());
    }

    public function materials(): HasMany
    {
        return $this->hasMany(LibraryMaterial::class, 'category_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(LibraryCategory::class, 'parent_id');
    }

    public function childs(): HasMany
    {
        return $this->hasMany(LibraryCategory::class, 'parent_id');
    }

    public function getTotalMaterialsAttribute()
    {
        return $this->countLibraryMaterialsRecursive();
    }

    public function getActiveMaterialsAttribute()
    {
        return $this->countLibraryMaterialsRecursive('Active');
    }

    // protected function countLibraryMaterialsRecursive(LibraryCategory $category,$stat): int
    // {
    //     if(in_array($stat, ['Active', 'Inactive']))
    //     {
    //         $count = $category->materials()->where('status','=',$stat)->count();
    //     }        
    //     else
    //     {
    //         $count = $category->materials()->count();
    //     }


    //     foreach ($category->childs as $child) {
    //         $count += $this->countLibraryMaterialsRecursive($child, $stat);
    //     }

    //     return $count;
    // }

    protected function countLibraryMaterialsRecursive($stat = null):int
    {
        $statusKey = $stat ?? 'all';
        return Cache::remember(
            "library_cat:{$this->id}:materials:{$statusKey}",
            now()->addMinutes(30),
            function () use ($stat) {

                $ids = [$this->id];
                $queue = [$this->id];

                while (!empty($queue)) {
                    $children = DB::table('library_categories')
                        ->whereIn('parent_id', $queue)
                        ->pluck('id')
                        ->toArray();

                    if (empty($children)) {
                        break;
                    }

                    $queue = $children;
                    $ids = array_merge($ids, $children);
                }

                $query = DB::table('library_materials')
                    ->whereIn('category_id', $ids);

                if (in_array($stat, ['Active', 'Inactive'])) {
                    $query->where('status', $stat);
                }

                return $query->count();
            }
        );

        return 0;
    }

}

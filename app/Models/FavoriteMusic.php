<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FavoriteMusic extends Model
{
    use HasFactory;

    protected $table = 'my_favorite_music';

    protected $fillable = [
        'title',
        'image',
        'description',
        'artist',
        'genre',
    ];

    public static function cleanupDuplicates()
    {
        // Keep only one instance of each track, deleting duplicates
        DB::statement("
            DELETE FROM my_favorite_music
            WHERE id NOT IN (
                SELECT MIN(id)
                FROM my_favorite_music
                GROUP BY title, artist
            )
        ");

        // Verify the cleanup worked
        return self::count();
    }
}

<?php

namespace App\Models\Link;

use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Generator extends Model
{
    use HasFactory;

    /**
     * Генерация кода
     *
     * @param $len
     * @return string
     */
    public static function generateCode($len): string
    {
        $code = Str::random($len);
        if (Link::where('code', $code)->exists()) {
            return self::generateCode($len);
        }

        return $code;
    }
}

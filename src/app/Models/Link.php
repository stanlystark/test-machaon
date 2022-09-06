<?php

namespace App\Models;

use App\Casts\LinkTargetCast;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'target'
    ];

    // Преобразование из закодированного состояния в обычное и обратно
    protected $casts = [
        'target' => LinkTargetCast::class
    ];

    // Получение данных для переадресации
    public static function getUrl($code)
    {
        $link = self::where('code', $code)->first();

        if ($link) {
            return route("redirect", ['url' => urlencode($link->target), 'id' => $link->id]);
        }
        return route("index");

    }

    // Создание ссылки
    public static function getShortCode($url)
    {
        $code = self::generateCode(8);

        $link = new Link();
        $link->code = $code;
        $link->target = $url;
        $link->save();

        return $code;
    }

    // Генерация кода
    private static function generateCode($len)
    {
        $code = Str::random($len);
        if (self::where('code', $code)->exists()) {
            return self::generateCode($len);
        }
        return $code;
    }

    // Ссылка по коду
    public static function getByCode($code)
    {
        $link = self::where('code', $code)->first();
        return [
            'target' => $link->target
        ];
    }

    // Список ссылок
    public static function getLinks(array $data)
    {
        if (!empty($data)) {
            return self::where(function ($query) use ($data) {
                if (isset($data['from'])) $query->where('created_at', '>', Carbon::createFromTimestamp($data['from'])->toDateTimeString());
                if (isset($data['to'])) $query->where('created_at', '<', Carbon::createFromTimestamp($data['to'])->toDateTimeString());
            })->select('code', 'target')->get();
        }
        return self::select('code', 'target')->get();
    }

    // Информация о ссылке по коду
    public static function getByCodeAdmin($data)
    {
        $link = self::where('code', $data['code'])->first();

        $stats = LinkStatistic::getStats($link->id, $data);

        return [
            'target' => $link->target,
            'count' => count($stats),
            'transitions' => $stats
        ];
    }

    // Обновление ссылки
    public static function updateLink($data)
    {
        if (isset($data['code']) && isset($data['target'])) {
            $link = self::where('code', $data['code'])->first();

            self::where('id', $link->id)->update([
                'target' => $data['target']
            ]);

            return 'success';
        }
        return 'fail';
    }

    // Удаление ссылки
    public static function removeLink($code)
    {
        $link = self::where('code', $code)->first();
        LinkStatistic::where('link_id', $link->id)->delete();
        self::where('id', $link->id)->delete();
        return 'success';
    }

    // Получение списка переходов
    public static function getTransitions($data)
    {
        return LinkStatistic::getAll($data);
    }
}

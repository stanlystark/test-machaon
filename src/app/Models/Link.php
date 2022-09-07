<?php

namespace App\Models;

use App\Casts\LinkTargetCast;
use App\Models\Link\Generator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'code',
        'target',
    ];

    /**
     * Преобразование из закодированного состояния в обычное и обратно
     *
     * @var string[]
     */
    protected $casts = [
        'target' => LinkTargetCast::class,
    ];

    /**
     * Получение данных для переадресации
     *
     * @param $ip
     * @param $agent
     * @param $code
     * @return string
     */
    public static function getUrl($ip, $agent, $code): string
    {
        $link = self::where('code', $code)->first();

        if ($link) {
            // Сбор информации о пользователе
            LinkStatistic::collectData($link->id, $ip, $agent);
            // Возвращаем ссылку
            return $link->target;
        }

        return route('index');
    }

    /**
     * Создание ссылки
     *
     * @param $url
     * @return string
     */
    public static function getShortCode($url): string
    {
        $code = Generator::generateCode(8);

        $link = new Link();
        $link->code = $code;
        $link->target = $url;
        $link->save();

        return $code;
    }

    /**
     * Возвращение ссылки по коду
     *
     * @param $code
     * @return array
     */
    public static function getByCode($code): array
    {
        $link = self::where('code', $code)->first();

        return [
            'target' => $link->target,
        ];
    }

    /**
     * Список ссылок
     *
     * @param  array  $data
     * @return mixed
     */
    public static function getLinks(array $data): mixed
    {
        if (! empty($data)) {
            return self::where(function ($query) use ($data) {
                if (isset($data['from'])) {
                    $query->where('created_at', '>', Carbon::createFromTimestamp($data['from'])->toDateTimeString());
                }
                if (isset($data['to'])) {
                    $query->where('created_at', '<', Carbon::createFromTimestamp($data['to'])->toDateTimeString());
                }
            })->select('code', 'target')->get();
        }

        return self::select('code', 'target')->get();
    }

    /**
     * Информация о ссылке по коду
     *
     * @param $data
     * @return array
     */
    public static function getByCodeAdmin($data): array
    {
        $link = self::where('code', $data['code'])->first();

        $stats = LinkStatistic::getStats($link->id, $data);

        return [
            'target' => $link->target,
            'count' => count($stats),
            'transitions' => $stats,
        ];
    }

    /**
     * Обновление ссылки
     *
     * @param $data
     * @return string
     */
    public static function updateLink($data): string
    {
        if (isset($data['code']) && isset($data['target'])) {
            $link = self::where('code', $data['code'])->first();

            self::where('id', $link->id)->update([
                'target' => $data['target'],
            ]);

            return 'success';
        }

        return 'fail';
    }

    /**
     * Удаление ссылки
     *
     * @param $code
     * @return string
     */
    public static function removeLink($code): string
    {
        $link = self::where('code', $code)->first();
        LinkStatistic::where('link_id', $link->id)->delete();
        self::where('id', $link->id)->delete();

        return 'success';
    }

    /**
     * Получение списка переходов
     *
     * @param $data
     * @return mixed
     */
    public static function getTransitions($data): mixed
    {
        return LinkStatistic::getAll($data);
    }
}

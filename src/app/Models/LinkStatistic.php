<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LinkStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'link_id',
        'ip',
        'agent'
    ];

    // Сбор информации о пользователе
    public static function collectData($id, $ip, $agent)
    {
        try {
            $data = new LinkStatistic();
            $data->link_id = $id;
            $data->ip = $ip;
            $data->agent = $agent;
            $data->save();
        } catch (\Exception $exception) {
            Log::error($exception);
        }
    }

    // Получение статистики по ссылке
    public static function getStats($id, $data = [])
    {
        if (!empty($data)) {
            return self::where('link_id', $id)->where(function ($query) use ($data) {
                if (isset($data['from'])) $query->where('created_at', '>', Carbon::createFromTimestamp($data['from'])->toDateTimeString());
                if (isset($data['to'])) $query->where('created_at', '<', Carbon::createFromTimestamp($data['to'])->toDateTimeString());
            })->select('ip', 'agent')->get();
        }
        return self::select('ip', 'agent')->get();
    }

    // Получение всей статистики
    public static function getAll($data = [])
    {
        if (!empty($data)) {
            return self::where(function ($query) use ($data) {
                if (isset($data['from'])) $query->where('created_at', '>', Carbon::createFromTimestamp($data['from'])->toDateTimeString());
                if (isset($data['to'])) $query->where('created_at', '<', Carbon::createFromTimestamp($data['to'])->toDateTimeString());
            })->select('ip', 'agent')->get();
        }
        return self::select('ip', 'agent')->get();
    }
}

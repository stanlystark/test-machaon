<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckCodeRequest;
use App\Http\Requests\StoreLinkRequest;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkUserController extends Controller
{
    // Универсальная ошибка
    public function fail()
    {
        return response()->json('fail');
    }

    // Создаем ссылку
    public function makeLink(StoreLinkRequest $request)
    {
        $validated = $request->validated();
        $code = Link::getShortCode($validated['url']);

        return response()->json([
            'code' => $code,
            'target' => $validated['url'],
            'link' => $request->getSchemeAndHttpHost() . '/' . $code
        ]);
    }

    // Получаем информацию по коду
    public function getLink(CheckCodeRequest $request)
    {
        return response()->json(Link::getByCode($request->input('code')));
    }
}

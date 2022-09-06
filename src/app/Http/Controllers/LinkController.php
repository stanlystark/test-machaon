<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Models\Link;
use App\Models\LinkStatistic;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    // Обработка кода
    public function goLink(Request $request, $code)
    {
        return redirect(Link::getUrl($code), 307);
    }

    // Создание ссылки
    public function makeLink(StoreLinkRequest $request)
    {
        $validated = $request->validated();

        return redirect(route("index"))->withInput()->with(["shortened" => Link::getShortCode($validated['url'])]);
    }

    // Переадресация и сбор данных
    public function redirect(Request $request)
    {
        LinkStatistic::collectData($request->input('id'), $request->getClientIp(), $request->userAgent());
        return redirect(urldecode($request->input('url')));
    }

}

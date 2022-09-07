<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckCodeRequest;
use App\Http\Requests\StoreLinkRequest;
use App\Models\Link;

class LinkUserController extends Controller
{
    /**
     * Универсальная ошибка
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fail()
    {
        return response()->json('fail', 418);
    }

    /**
     * Создаем ссылку
     *
     * @param StoreLinkRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeLink(StoreLinkRequest $request)
    {
        $validated = $request->validated();
        $code = Link::getShortCode($validated['url']);

        return response()->json([
            'code' => $code,
            'target' => $validated['url'],
            'link' => $request->getSchemeAndHttpHost().'/'.$code,
        ]);
    }

    /**
     * Получаем информацию по коду
     *
     * @param CheckCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLink(CheckCodeRequest $request)
    {
        return response()->json(Link::getByCode($request->input('code')));
    }
}

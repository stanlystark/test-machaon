<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Обработка кода
     *
     * @param Request $request
     * @param $code
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function goLink(Request $request, $code)
    {
        return redirect(Link::getUrl($request->ip(), $request->userAgent(), $code));
    }

    /**
     * Создание ссылки
     *
     * @param StoreLinkRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function makeLink(StoreLinkRequest $request)
    {
        $validated = $request->validated();

        return redirect(route('index'))->withInput()->with(['shortened' => Link::getShortCode($validated['url'])]);
    }
}

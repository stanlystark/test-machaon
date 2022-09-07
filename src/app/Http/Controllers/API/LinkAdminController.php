<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckCodeRequest;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkAdminController extends Controller
{
    // Список ссылок
    public function getLinks(Request $request)
    {
        return response()->json(Link::getLinks($request->all()));
    }

    // Информация по коду
    public function getLink(CheckCodeRequest $request)
    {
        $validated = $request->validated();

        return response()->json(Link::getByCodeAdmin($validated));
    }

    // Обновление ссылки
    public function updateLink(CheckCodeRequest $request)
    {
        $validated = $request->validated();

        return response()->json(Link::updateLink($validated));
    }

    // Удаление ссылки
    public function removeLink(CheckCodeRequest $request)
    {
        $validated = $request->validated();

        return response()->json(Link::removeLink($validated['code']));
    }

    // Список переходов
    public function getTransitions(Request $request)
    {
        return response()->json(Link::getTransitions($request->all()));
    }
}

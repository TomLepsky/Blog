<?php

namespace App\Trait;

use App\Config;
use Symfony\Component\HttpFoundation\Request;

trait PaginatorTrait
{
    public function getPaginatorArgs(Request $request) : array
    {
        $page = (int) $request->query->get('page', Config::DEFAULT_FIRST_PAGE);

        $pageSize = (int) $request->query->get('pageSize', Config::DEFAULT_PAGE_SIZE);
        $pageSize = $pageSize > Config::MAX_PAGE_SIZE ? Config::MAX_PAGE_SIZE : $pageSize;
        $pageSize = $pageSize < 0 ? Config::DEFAULT_PAGE_SIZE : $pageSize;

        return [$page, $pageSize];
    }
}

<?php

namespace App\Infrastructure\Cms\Domain\Gamification\Routing\DTOs;

class RouteResolveInputDTO
{
    public function __construct(
        public string $routeName,
        public array $routeParams,  // $request->route()->parameters()
        public array $queryParams,  // $request->query()
    ) {}
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $roles)
    {
        $funcoes = $request->user()->funcao;
        $rolesExploded = explode('|', $funcoes);

        if ($request->user()->status != 'active') {
            return response()->view('content.errors.inactive', [], 401);
        }

        if ($request->user()->primeiro_acesso) {
            return to_route('primeiro-acesso');
        }

        if ($request->user()->status != 'active') {
            return response()->view('content.errors.inactive', [], 401);
        }

        if ($funcoes === $roles) {
            return $next($request);
        }

        foreach($rolesExploded as $r){
            if (in_array($r, explode('|', $roles))) {
                return $next($request);
            }
        }

        return response()->view('content.errors.custom', ["message" => "Você não tem permissões para acessar essa página."], 401);
        abort(401);
    }
}

<?php

namespace app\http\middleware;

class Langswitch
{
    public function handle($request, \Closure $next)
    {
        //$request->lang = session('switch_lang')?session('switch_lang'):'en-us';


        return $next($request);
    }
}

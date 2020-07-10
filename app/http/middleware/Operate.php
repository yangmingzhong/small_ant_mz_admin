<?php

namespace app\http\middleware;

class Operate
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        if($request->isPost()) {
            $operateLogMod = new \app\adminback\model\Operate();
            $operateLogMod->writeLog($request);

        }
        return $response;
    }
}

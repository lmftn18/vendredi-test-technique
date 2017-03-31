<?php

namespace App\Http\Middleware;

use Closure;

class HttpsProtocol {

    public function handle($request, Closure $next)
    {
        // heroku proxify the ssl connection, so we get a redirect loop if we don't add this line
        // to trust the X-Forwarded-Proto header that declares it is forwarding a HTTPS request
        $request->setTrustedProxies( [ $request->getClientIp() ] );
        if (!$request->secure() && env('APP_ENV') === 'production') {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
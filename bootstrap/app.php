<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\WorkerMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {


                $middleware->redirectUsersTo(function () {

                $user = auth()->user();

                if (!$user) {
                    return route('login');
                }

                return match ($user->type) {
                    'admin' => route('admin.index'),
                    'user' => route('user.index'),
                    'worker' => route('worker.index'),



                };

                });


                $middleware->web(append: [
                    \App\Http\Middleware\NoCache::class,
                ]);

          $middleware->alias([
            'admin' => AdminMiddleware::class,
            'worker' => WorkerMiddleware::class,
            'user' => UserMiddleware::class,
            'nocache' => \App\Http\Middleware\NoCache::class,
          ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

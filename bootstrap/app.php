<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Registrar middlewares personalizados
        $middleware->alias([
            'permission' => \App\Http\Middleware\EnsureUserHasPermission::class,
            'module.access' => \App\Http\Middleware\EnsureModuleAccess::class,
            'admin-access' => \App\Http\Middleware\EnsureAdminAccess::class,
            'user.owns.person' => \App\Http\Middleware\EnsureUserOwnsPerson::class,
            'company.owns' => \App\Http\Middleware\EnsureUserOwnsCompany::class,
            'work-integrity.payment' => \App\Http\Middleware\EnsureWorkIntegrityPayment::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Manejar excepciones de modelos no encontrados
        $exceptions->render(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Registro no encontrado.'
                ], 404);
            }

            // Obtener el modelo del error
            $model = class_basename($e->getModel());
            
            // Mapeo de modelos a rutas de índice
            $routeMap = [
                'Person' => 'people.index',
                'EducationalSkill' => 'people.index',
                'WorkExperience' => 'people.index',
                'PersonalReference' => 'people.index',
                'Aspiration' => 'people.index',
                'User' => 'dashboard',
            ];

            // Obtener la ruta de redirección
            $redirectRoute = $routeMap[$model] ?? 'dashboard';

            // Mensajes personalizados según el modelo
            $messages = [
                'Person' => 'La persona solicitada no existe o ha sido eliminada.',
                'EducationalSkill' => 'La habilidad educativa no existe o ha sido eliminada.',
                'WorkExperience' => 'La experiencia laboral no existe o ha sido eliminada.',
                'PersonalReference' => 'La referencia personal no existe o ha sido eliminada.',
                'Aspiration' => 'La aspiración no existe o ha sido eliminada.',
                'User' => 'El usuario no existe o ha sido eliminado.',
            ];

            $message = $messages[$model] ?? 'El registro solicitado no existe o ha sido eliminado.';

            return redirect()->route($redirectRoute)->with('error', $message);
        });

        // Manejar excepciones 404 generales
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Recurso no encontrado.'
                ], 404);
            }

            // Si no es una petición de API, redirigir al dashboard
            return redirect()->route('dashboard')->with('error', 'La página solicitada no existe.');
        });
    })->create();

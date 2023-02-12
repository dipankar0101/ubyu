<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'admin' => \App\Http\Middleware\RedirectIfNotAdmin::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        'dashboard' => \App\Http\Middleware\dashboard\dashboard::class,

        'view_media' => \App\Http\Middleware\media\view_media::class,
        'edit_media' => \App\Http\Middleware\media\edit_media::class,
        'delete_media' => \App\Http\Middleware\media\delete_media::class,
        'add_media' => \App\Http\Middleware\media\add_media::class,

        'directory_view' => \App\Http\Middleware\directory\directory_view::class,
        'directory_create' => \App\Http\Middleware\directory\directory_create::class,
        'directory_update' => \App\Http\Middleware\directory\directory_update::class,
        'directory_delete' => \App\Http\Middleware\directory\directory_delete::class,

        'directory_advertise_view' => \App\Http\Middleware\directoryAdv\directory_advertise_view::class,
        'directory_advertise_create' => \App\Http\Middleware\directoryAdv\directory_advertise_create::class,
        'directory_advertise_update' => \App\Http\Middleware\directoryAdv\directory_advertise_update::class,
        'directory_advertise_delete' => \App\Http\Middleware\directoryAdv\directory_advertise_delete::class,

        'directory_detail_view' => \App\Http\Middleware\directoryDetail\directory_detail_view::class,
        'directory_detail_create' => \App\Http\Middleware\directoryDetail\directory_detail_create::class,
        'directory_detail_update' => \App\Http\Middleware\directoryDetail\directory_detail_update::class,
        'directory_detail_delete' => \App\Http\Middleware\directoryDetail\directory_detail_delete::class,

        'directory_employee_view' => \App\Http\Middleware\directoryEmp\directory_employee_view::class,
        'directory_employee_create' => \App\Http\Middleware\directoryEmp\directory_employee_create::class,
        'directory_employee_update' => \App\Http\Middleware\directoryEmp\directory_employee_update::class,
        'directory_employee_delete' => \App\Http\Middleware\directoryEmp\directory_employee_delete::class,

        'view_news' => \App\Http\Middleware\news\view_news::class,
        'edit_news' => \App\Http\Middleware\news\edit_news::class,
        'delete_news' => \App\Http\Middleware\news\delete_news::class,
        'add_news' => \App\Http\Middleware\news\add_news::class,

        'crop_view' => \App\Http\Middleware\crops\crop_view::class,
        'crop_create' => \App\Http\Middleware\crops\crop_create::class,
        'crop_update' => \App\Http\Middleware\crops\crop_update::class,
        'crop_delete' => \App\Http\Middleware\crops\crop_delete::class,

        'crop_segment_view' => \App\Http\Middleware\cropSegment\crop_segment_view::class,
        'crop_segment_create' => \App\Http\Middleware\cropSegment\crop_segment_create::class,
        'crop_segment_update' => \App\Http\Middleware\cropSegment\crop_segment_update::class,
        'crop_segment_delete' => \App\Http\Middleware\cropSegment\crop_segment_delete::class,

        'crop_segment_detail_view' => \App\Http\Middleware\cropSegmentDet\crop_segment_detail_view::class,
        'crop_segment_detail_create' => \App\Http\Middleware\cropSegmentDet\crop_segment_detail_create::class,
        'crop_segment_detail_update' => \App\Http\Middleware\cropSegmentDet\crop_segment_detail_update::class,
        'crop_segment_detail_delete' => \App\Http\Middleware\cropSegmentDet\crop_segment_detail_delete::class,

        'slider_view' => \App\Http\Middleware\sliders\slider_view::class,
        'slider_create' => \App\Http\Middleware\sliders\slider_create::class,
        'slider_update' => \App\Http\Middleware\sliders\slider_update::class,
        'slider_delete' => \App\Http\Middleware\sliders\slider_delete::class,

        'weather_view' => \App\Http\Middleware\weather\weather_view::class,
        'weather_update' => \App\Http\Middleware\weather\weather_update::class,

        'view_manage_admin' => \App\Http\Middleware\manage_admin\view_manage_admin::class,
        'edit_manage_admin' => \App\Http\Middleware\manage_admin\edit_manage_admin::class,
        'delete_manage_admin' => \App\Http\Middleware\manage_admin\delete_manage_admin::class,
        'add_manage_admin' => \App\Http\Middleware\manage_admin\add_manage_admin::class,

        'view_admin_type' => \App\Http\Middleware\admin_type\view_admin_type::class,
        'edit_admin_type' => \App\Http\Middleware\admin_type\edit_admin_type::class,
        'delete_admin_type' => \App\Http\Middleware\admin_type\delete_admin_type::class,
        'add_admin_type' => \App\Http\Middleware\admin_type\add_admin_type::class,

        'manage_role' => \App\Http\Middleware\manage_role\manage_role::class,
    ];
}

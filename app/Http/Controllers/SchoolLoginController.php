<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchoolLoginController extends Controller
{

    /**
     * @var Guard|\Illuminate\Auth\SessionGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->guard = $auth->guard(config('platform.guard'));

        $this->middleware('guest', [
            'except' => [
                'schoolLogout',
                'adminLogout',
            ],
        ]);
    }

    /**
     * @return Factory|View
     */
    public function showLoginForm(Request $request)
    {
        $user = $request->cookie('lockUser');

        /** @var EloquentUserProvider $provider */
        $provider = $this->guard->getProvider();

        $model = $provider->createModel()->find($user);

        return view('platform::auth.login', [
            'isLockUser' => optional($model)->exists ?? false,
            'lockUser'   => $model,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function schoolLogout(School $school)
    {
        $this->guard->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return request()->wantsJson()
            ? new JsonResponse([], 204)
            : self::missingSchoolResponse($school);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public static function adminLogout()
    {
        auth()
            ->guard(config('platform.guard'))
            ->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return request()->wantsJson()
            ? new JsonResponse([], 204)
            : self::missingSchoolResponse();
    }

    protected static function missingSchoolResponse(School $school = null)
    {
        return is_null($school) ?
            redirect('/admin') :
            redirect('/login/' . $school->login_url);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\BrowserStat;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrackBrowser
{
    public function handle(Request $request, Closure $next)
    {
        $userAgent = $request->header('User-Agent');
        $browser = $this->getBrowser($userAgent);

        // Find or create the browser stat record
        $browserStat = BrowserStat::updateOrCreate(
            ['browser_name' => $browser],
            ['visit_count' => DB::raw('visit_count + 1')]
        );

        // Associate the browser stat with the logged-in user
        if (Auth::check()) {
            $user = Auth::user();

            // Manually insert into the user_tracking table
            DB::table('user_tracking')->insert([
                'user_id' => $user->user_id,
                'browser_id' => $browserStat->browser_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $next($request);
    }

    private function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
            return 'Internet Explorer';
        } elseif (strpos($userAgent, 'Edg') !== false) { // Microsoft Edge
            return 'Microsoft Edge';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Mozilla Firefox';
        } elseif (strpos($userAgent, 'Chrome') !== false) {
            return 'Google Chrome';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'Opera') !== false) {
            return 'Opera';
        } else {
            return 'Unknown';
        }
    }
}

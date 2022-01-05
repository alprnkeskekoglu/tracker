<?php

namespace Dawnstar\Tracker\Foundation;

use Dawnstar\Core\Models\Url;
use Dawnstar\Tracker\Models\TrackerBrowser;
use Dawnstar\Tracker\Models\TrackerCookie;
use Dawnstar\Tracker\Models\TrackerDevice;
use Dawnstar\Tracker\Models\TrackerOperatingSystem;
use Dawnstar\Tracker\Models\TrackerSession;
use Dawnstar\Tracker\Models\TrackerVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Jenssegers\Agent\Agent;

class Tracker
{
    /**
     * @var Agent
     */
    protected Agent $userAgent;

    public function __construct()
    {
        $this->userAgent = new Agent();
    }

    public function init(): void
    {
        if (!$this->canVisitSave()) {
            return;
        }

        $device = $this->getDevice();
        $operatingSystem = $this->getOperatingSystem();
        $browser = $this->getBrowser();
        $cookie = $this->getCookie($device, $operatingSystem, $browser);
        $session = $this->getSession($cookie);
        $this->visit($cookie, $session);
    }

    /**
     * @param TrackerDevice $device
     * @param TrackerOperatingSystem $operatingSystem
     * @param TrackerBrowser $browser
     * @return TrackerCookie
     */
    public function getCookie(TrackerDevice $device, TrackerOperatingSystem $operatingSystem, TrackerBrowser $browser): TrackerCookie
    {
        $cookieKey = Cookie::get('_datr');

        if (is_null($cookieKey)) {
            $cookieKey = $this->getUniqueKey();
            Cookie::queue('_datr', $cookieKey, 60 * 60 * 24);
        }

        return TrackerCookie::firstOrCreate(
            [
                'key' => $cookieKey
            ],
            [
                'device_id' => $device->id,
                'operating_system_id' => $operatingSystem->id,
                'browser_id' => $browser->id,
                'user_id' => auth('web')->id()
            ]
        );
    }

    /**
     * @param TrackerCookie $cookie
     * @return TrackerSession
     */
    public function getSession(TrackerCookie $cookie): TrackerSession
    {
        $sessionKey = session('_datr');

        if (is_null($sessionKey)) {
            $sessionKey = $this->getUniqueKey();
            session(['_datr' => $sessionKey]);
        }

        return TrackerSession::firstOrCreate(
            [
                'key' => $sessionKey
            ],
            [
                'cookie_id' => $cookie->id,
            ]
        );
    }

    /**
     * @return TrackerDevice
     */
    public function getDevice(): TrackerDevice
    {
        $deviceName = strtolower($this->userAgent->deviceType());
        return TrackerDevice::firstOrCreate(['name' => $deviceName]);
    }

    /**
     * @return TrackerOperatingSystem
     */
    public function getOperatingSystem(): TrackerOperatingSystem
    {
        $operatingSystemName = str_replace(['androidos'], ['android'], strtolower($this->userAgent->platform()));

        return TrackerOperatingSystem::firstOrCreate(['name' => $operatingSystemName]);
    }

    /**
     * @return TrackerBrowser
     */
    public function getBrowser(): TrackerBrowser
    {
        $browserName = strtolower($this->userAgent->browser());
        return TrackerBrowser::firstOrCreate(['name' => $browserName]);
    }

    /**
     * @param TrackerCookie $cookie
     * @param TrackerSession $session
     */
    private function visit(TrackerCookie $cookie, TrackerSession $session): void
    {
        $request = request();

        $url = $this->getUrl($request);
        $ip = $request->ip();
        $referer = parse_url($request->headers->get('referer'), PHP_URL_HOST);
        list($queryString, $utm) = $this->getQueryStringAndUtm($request);

        TrackerVisit::create(
            [
                'cookie_id' => $cookie->id,
                'session_id' => $session->id,
                'url_id' => $url ? $url->id : null,
                'ip' => $ip,
                'hour' => date('H'),
                'week' => date('N'),
                'referer' => $referer,
                'query_string' => $queryString != '' ? $queryString : null,
                'utm' => json_encode($utm)
            ]
        );
    }

    /**
     * @return bool
     */
    private function canVisitSave(): bool
    {
        $request = request();

        if ($request->ajax() || \Str::startsWith($request->getPathInfo(), '/dawnstar')) {
            return false;
        }

        return true;
    }

    /**
     * @param Request $request
     * @return Url|null
     */
    private function getUrl(Request $request): ?Url
    {
        $url = trim(ltrim($request->getPathInfo(), '/'));

        return Url::where('url', 'like', "%$url")->first();
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getQueryStringAndUtm(Request $request): array
    {
        $queryString = '';
        $i = 0;
        $utm = [];
        foreach ($request->all() as $key => $value) {
            if (!is_array($value)) {
                if (strpos($key, 'utm_') !== false) {
                    $utm[$key] = $value;
                }
                if ($value) {
                    if ($i == 0) {
                        $queryString .= '?' . $key . '=' . urlencode($value);
                    } else {
                        $queryString .= '&' . $key . '=' . urlencode($value);
                    }
                }
                $i++;
            }
        }

        return [$queryString, $utm];
    }

    /**
     * @return string
     */
    private function getUniqueKey(): string
    {
        return strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 12));
    }
}

<?php

namespace Pterodactyl\Http\Controllers\Admin\Arix;

use Illuminate\View\View;
use Prologue\Alerts\AlertsMessageBag;
use Illuminate\View\Factory as ViewFactory;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Http\Requests\Admin\Arix\ArixSocialRequest;
use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;

class ArixSocialController extends Controller
{
    public function __construct(
        private AlertsMessageBag $alert,
        private SettingsRepositoryInterface $settings,
        private ViewFactory $view
    ) {}

    public function index(): View
    {
        return $this->view->make('admin.arix.social', [
            'socials' => json_decode($this->settings->get('settings::arix:socials', '[]'), true),
            'socialButtons' => $this->settings->get('settings::arix:socialButtons', false),
            'discordBox' => $this->settings->get('settings::arix:discordBox', true),
        ]);
    }

    public function store(ArixSocialRequest $request)
    {
        foreach ($request->normalize() as $key => $value) {
            if (is_array($value)) {
                $filtered = array_values(array_filter($value, function($item) {
                    if (is_array($item)) {
                        return !empty(trim($item['link'] ?? '')) || !empty(trim($item['title'] ?? ''));
                    }
                    return !empty($item);
                }));
                $value = json_encode($filtered);
            } else {
                if ($value === '' || $value === null) {
                    continue;
                }
            }
            $this->settings->set('settings::' . $key, $value);
        }
        $this->alert->success('Theme settings have been updated successfully.')->flash();
        return redirect()->route('admin.arix.social');
    }
}
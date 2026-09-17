<?php

namespace Pterodactyl\Http\Requests\Admin\Arix;

use Pterodactyl\Http\Requests\Admin\AdminFormRequest;

class ArixAnnouncementRequest extends AdminFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'arix:announcement' => 'required|in:false,true',
            'arix:announcementColor' => 'required|string',
            'arix:announcementIcon' => 'required|string',
            'arix:announcementMessage' => 'nullable|string',
            'arix:announcementCta' => 'required|in:false,true',
            'arix:announcementCtaTitle' => 'nullable|string',
            'arix:announcementCtaLink' => 'nullable|string',
            'arix:announcementDismissable' => 'required|in:false,true',
            'arix:announcementType' => 'nullable|string',
            'arix:announcementCloseable' => 'nullable|in:false,true',
        ];
    }
}
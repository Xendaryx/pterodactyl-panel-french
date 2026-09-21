<?php

namespace Pterodactyl\Http\Requests\Admin\Settings;

use Pterodactyl\Http\Requests\Admin\AdminFormRequest;

class AdvancedSettingsFormRequest extends AdminFormRequest
{
    /**
     * Return all the rules to apply to this request's data.
     */
    public function rules(): array
    {
        return [
            'recaptcha:enabled' => 'required|in:true,false',
            'recaptcha:secret_key' => 'required|string|max:191',
            'recaptcha:website_key' => 'required|string|max:191',
            'pterodactyl:guzzle:timeout' => 'required|integer|between:1,60',
            'pterodactyl:guzzle:connect_timeout' => 'required|integer|between:1,60',
            'pterodactyl:client_features:allocations:enabled' => 'required|in:true,false',
            'pterodactyl:client_features:allocations:range_start' => [
                'nullable',
                'required_if:pterodactyl:client_features:allocations:enabled,true',
                'integer',
                'between:1024,65535',
            ],
            'pterodactyl:client_features:allocations:range_end' => [
                'nullable',
                'required_if:pterodactyl:client_features:allocations:enabled,true',
                'integer',
                'between:1024,65535',
                'gt:pterodactyl:client_features:allocations:range_start',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'recaptcha:enabled' => 'reCAPTCHA activé',
            'recaptcha:secret_key' => 'Clé secrète reCAPTCHA',
            'recaptcha:website_key' => 'Clé de site reCAPTCHA',
            'pterodactyl:guzzle:timeout' => 'Délai d’attente de la requête HTTP',
            'pterodactyl:guzzle:connect_timeout' => 'Délai d’attente de la connexion HTTP',
            'pterodactyl:client_features:allocations:enabled' => 'Création automatique des allocations activée',
            'pterodactyl:client_features:allocations:range_start' => 'Port de début',
            'pterodactyl:client_features:allocations:range_end' => 'Port de fin',
        ];
    }
}

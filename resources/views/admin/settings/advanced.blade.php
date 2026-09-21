@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'advanced'])

@section('title')
    Paramètres avancés
@endsection

@section('content-header')
    <h1>Paramètres avancés<small>Configurez les paramètres avancés du panel.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Administration</a></li>
        <li class="active">Paramètres</li>
    </ol>
@endsection

@section('content')
    @yield('settings::nav')
    <div class="row">
        <div class="col-xs-12">
            <form action="" method="POST">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">reCAPTCHA</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Statut</label>
                                <div>
                                    <select class="form-control" name="recaptcha:enabled">
                                        <option value="true">Activé</option>
                                        <option value="false" @if(old('recaptcha:enabled', config('recaptcha.enabled')) == '0') selected @endif>Désactivé</option>
                                    </select>
                                    <p class="text-muted small">Si activé, les formulaires de connexion et de réinitialisation du mot de passe effectueront une vérification CAPTCHA silencieuse et afficheront un CAPTCHA visible si nécessaire.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Clé du site</label>
                                <div>
                                    <input type="text" required class="form-control" name="recaptcha:website_key" value="{{ old('recaptcha:website_key', config('recaptcha.website_key')) }}">
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Clé secrète</label>
                                <div>
                                    <input type="text" required class="form-control" name="recaptcha:secret_key" value="{{ old('recaptcha:secret_key', config('recaptcha.secret_key')) }}">
                                    <p class="text-muted small">Utilisée pour la communication entre votre site et Google. Veillez à conserver cette clé secrète.</p>
                                </div>
                            </div>
                        </div>
                        @if($showRecaptchaWarning)
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="alert alert-warning no-margin">
                                        Vous utilisez actuellement les clés reCAPTCHA fournies par défaut avec ce panel. Pour renforcer la sécurité, il est recommandé de <a href="https://www.google.com/recaptcha/admin">générer de nouvelles clés reCAPTCHA invisibles</a> associées spécifiquement à votre site.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Connexions HTTP</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Délai de connexion</label>
                                <div>
                                    <input type="number" required class="form-control" name="pterodactyl:guzzle:connect_timeout" value="{{ old('pterodactyl:guzzle:connect_timeout', config('pterodactyl.guzzle.connect_timeout')) }}">
                                    <p class="text-muted small">Durée maximale, en secondes, à attendre pour établir une connexion avant de générer une erreur.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Délai de requête</label>
                                <div>
                                    <input type="number" required class="form-control" name="pterodactyl:guzzle:timeout" value="{{ old('pterodactyl:guzzle:timeout', config('pterodactyl.guzzle.timeout')) }}">
                                    <p class="text-muted small">Durée maximale, en secondes, à attendre pour qu’une requête se termine avant de générer une erreur.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Création automatique des allocations</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Statut</label>
                                <div>
                                    <select class="form-control" name="pterodactyl:client_features:allocations:enabled">
                                        <option value="false">Désactivé</option>
                                        <option value="true" @if(old('pterodactyl:client_features:allocations:enabled', config('pterodactyl.client_features.allocations.enabled'))) selected @endif>Activé</option>
                                    </select>
                                    <p class="text-muted small">Si cette option est activée, les utilisateurs pourront créer automatiquement de nouvelles allocations pour leur serveur depuis l’interface.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Port de début</label>
                                <div>
                                    <input type="number" class="form-control" name="pterodactyl:client_features:allocations:range_start" value="{{ old('pterodactyl:client_features:allocations:range_start', config('pterodactyl.client_features.allocations.range_start')) }}">
                                    <p class="text-muted small">Premier port de la plage pouvant être attribuée automatiquement.</p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Port de fin</label>
                                <div>
                                    <input type="number" class="form-control" name="pterodactyl:client_features:allocations:range_end" value="{{ old('pterodactyl:client_features:allocations:range_end', config('pterodactyl.client_features.allocations.range_end')) }}">
                                    <p class="text-muted small">Dernier port de la plage pouvant être attribuée automatiquement.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-footer">
                        {{ csrf_field() }}
                        <button type="submit" name="_method" value="PATCH" class="btn btn-sm btn-primary pull-right">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

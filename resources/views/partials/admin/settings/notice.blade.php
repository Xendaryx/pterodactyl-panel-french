@section('settings::notice')
    @if(config('pterodactyl.load_environment_only', false))
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-danger">
                    Votre Panel est actuellement configuré pour lire les paramètres uniquement depuis l’environnement. Vous devez définir <code>APP_ENVIRONMENT_ONLY=false</code> dans votre fichier d’environnement afin de pouvoir charger les paramètres dynamiquement.
                </div>
            </div>
        </div>
    @endif
@endsection

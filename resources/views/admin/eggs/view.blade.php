@extends('layouts.admin')

@section('title')
    Nids &rarr; Egg : {{ $egg->name }}
@endsection

@section('content-header')
    <h1>{{ $egg->name }}<small>{{ str_limit($egg->description, 50) }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Administration</a></li>
        <li><a href="{{ route('admin.nests') }}">Nids</a></li>
        <li><a href="{{ route('admin.nests.view', $egg->nest->id) }}">{{ $egg->nest->name }}</a></li>
        <li class="active">{{ $egg->name }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom nav-tabs-floating">
            <ul class="nav nav-tabs">
                <li class="active"><a href="{{ route('admin.nests.egg.view', $egg->id) }}">Configuration</a></li>
                <li><a href="{{ route('admin.nests.egg.variables', $egg->id) }}">Variables</a></li>
                <li><a href="{{ route('admin.nests.egg.scripts', $egg->id) }}">Script d’installation</a></li>
            </ul>
        </div>
    </div>
</div>
<form action="{{ route('admin.nests.egg.view', $egg->id) }}" enctype="multipart/form-data" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="form-group no-margin-bottom">
                                <label for="pName" class="control-label">Fichier de l’Egg</label>
                                <div>
                                    <input type="file" name="import_file" class="form-control" style="border: 0;margin-left:-10px;" />
                                    <p class="text-muted small no-margin-bottom">Pour remplacer les paramètres de cet Egg en important un nouveau fichier JSON, sélectionnez-le ici puis cliquez sur « Mettre à jour l’Egg ». Cette opération ne modifiera pas les commandes de démarrage ni les images Docker des serveurs existants.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            {!! csrf_field() !!}
                            <button type="submit" name="_method" value="PUT" class="btn btn-sm btn-danger pull-right">Mettre à jour l’Egg</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<form action="{{ route('admin.nests.egg.view', $egg->id) }}" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Configuration</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pName" class="control-label">Nom <span class="field-required"></span></label>
                                <input type="text" id="pName" name="name" value="{{ $egg->name }}" class="form-control" />
                                <p class="text-muted small">Un nom simple et lisible servant à identifier cet Egg.</p>
                            </div>
                            <div class="form-group">
                                <label for="pUuid" class="control-label">UUID</label>
                                <input type="text" id="pUuid" readonly value="{{ $egg->uuid }}" class="form-control" />
                                <p class="text-muted small">Identifiant unique global de cet Egg utilisé par le daemon pour l’identifier.</p>
                            </div>
                            <div class="form-group">
                                <label for="pAuthor" class="control-label">Auteur</label>
                                <input type="text" id="pAuthor" readonly value="{{ $egg->author }}" class="form-control" />
                                <p class="text-muted small">Auteur de cette version de l’Egg. L’importation d’une nouvelle configuration provenant d’un autre auteur modifiera cette valeur.</p>
                            </div>
                            <div class="form-group">
                                <label for="pDockerImage" class="control-label">Images Docker <span class="field-required"></span></label>
                                <textarea id="pDockerImages" name="docker_images" class="form-control" rows="4">{{ implode(PHP_EOL, $images) }}</textarea>
                                <p class="text-muted small">
                                    Images Docker disponibles pour les serveurs utilisant cet Egg. Saisissez une image par ligne. Les utilisateurs
                                    pourront choisir dans cette liste si plusieurs images sont disponibles.
                                    Vous pouvez également définir un nom d’affichage en plaçant le nom avant l’image,
                                    suivi du caractère barre verticale puis de l’URL de l’image. Exemple : <code>Nom affiché|ghcr.io/my/egg</code>
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="checkbox checkbox-primary no-margin-bottom">
                                    <input id="pForceOutgoingIp" name="force_outgoing_ip" type="checkbox" value="1" @if($egg->force_outgoing_ip) checked @endif />
                                    <label for="pForceOutgoingIp" class="strong">Forcer l’IP sortante</label>
                                    <p class="text-muted small">
                                        Force tout le trafic réseau sortant à utiliser comme IP source NAT l’adresse IP de l’allocation principale du serveur.
                                        Nécessaire au bon fonctionnement de certains jeux lorsque le Nœud possède plusieurs adresses IP publiques.
                                        <br>
                                        <strong>
                                            L’activation de cette option désactivera le réseau interne pour tous les serveurs utilisant cet Egg,
                                            les empêchant ainsi d’accéder en interne aux autres serveurs du même Nœud.
                                        </strong>
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pDescription" class="control-label">Description</label>
                                <textarea id="pDescription" name="description" class="form-control" rows="8">{{ $egg->description }}</textarea>
                                <p class="text-muted small">Description de cet Egg affichée dans le panel lorsque nécessaire.</p>
                            </div>
                            <div class="form-group">
                                <label for="pStartup" class="control-label">Commande de démarrage <span class="field-required"></span></label>
                                <textarea id="pStartup" name="startup" class="form-control" rows="8">{{ $egg->startup }}</textarea>
                                <p class="text-muted small">Commande de démarrage utilisée par défaut pour les nouveaux serveurs utilisant cet Egg.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigFeatures" class="control-label">Fonctionnalités</label>
                                <div>
                                    <select class="form-control" name="features[]" id="pConfigFeatures" multiple>
                                        @foreach(($egg->features ?? []) as $feature)
                                            <option value="{{ $feature }}" selected>{{ $feature }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-muted small">Fonctionnalités supplémentaires associées à cet Egg. Utiles pour configurer des modifications supplémentaires du panel.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Gestion des processus</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-warning">
                                <p>Les options de configuration suivantes ne doivent pas être modifiées sans comprendre le fonctionnement de ce système. Une modification incorrecte peut perturber le fonctionnement du daemon.</p>
                                <p>Tous les champs sont obligatoires sauf si vous sélectionnez une option dans la liste « Copier les paramètres depuis ». Dans ce cas, les champs peuvent rester vides afin d’utiliser les valeurs de cet Egg.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFrom" class="form-label">Copier les paramètres depuis</label>
                                <select name="config_from" id="pConfigFrom" class="form-control">
                                    <option value="">Aucun</option>
                                    @foreach($egg->nest->eggs as $o)
                                        <option value="{{ $o->id }}" {{ ($egg->config_from !== $o->id) ?: 'selected' }}>{{ $o->name }} &lt;{{ $o->author }}&gt;</option>
                                    @endforeach
                                </select>
                                <p class="text-muted small">Pour utiliser par défaut les paramètres d’un autre Egg, sélectionnez-le dans la liste ci-dessus.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStop" class="form-label">Commande d’arrêt</label>
                                <input type="text" id="pConfigStop" name="config_stop" class="form-control" value="{{ $egg->config_stop }}" />
                                <p class="text-muted small">Commande envoyée aux processus du serveur pour les arrêter proprement. Si vous devez envoyer un <code>SIGINT</code>, saisissez <code>^C</code> ici.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigLogs" class="form-label">Configuration des journaux</label>
                                <textarea data-action="handle-tabs" id="pConfigLogs" name="config_logs" class="form-control" rows="6">{{ ! is_null($egg->config_logs) ? json_encode(json_decode($egg->config_logs), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                                <p class="text-muted small">Cette valeur doit être une représentation JSON indiquant où les fichiers journaux sont stockés et si le daemon doit créer des journaux personnalisés.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFiles" class="form-label">Fichiers de configuration</label>
                                <textarea data-action="handle-tabs" id="pConfigFiles" name="config_files" class="form-control" rows="6">{{ ! is_null($egg->config_files) ? json_encode(json_decode($egg->config_files), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                                <p class="text-muted small">Cette valeur doit être une représentation JSON des fichiers de configuration à modifier et des éléments devant être modifiés.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStartup" class="form-label">Configuration du démarrage</label>
                                <textarea data-action="handle-tabs" id="pConfigStartup" name="config_startup" class="form-control" rows="6">{{ ! is_null($egg->config_startup) ? json_encode(json_decode($egg->config_startup), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                                <p class="text-muted small">Cette valeur doit être une représentation JSON des valeurs que le daemon doit rechercher lors du démarrage d’un serveur afin de déterminer si celui-ci est terminé.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" name="_method" value="PATCH" class="btn btn-primary btn-sm pull-right">Enregistrer</button>
                    <a href="{{ route('admin.nests.egg.export', $egg->id) }}" class="btn btn-sm btn-info pull-right" style="margin-right:10px;">Exporter</a>
                    <button id="deleteButton" type="submit" name="_method" value="DELETE" class="btn btn-danger btn-sm muted muted-hover">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#pConfigFrom').select2();
    $('#deleteButton').on('mouseenter', function (event) {
        $(this).find('i').html(' Supprimer l’Egg');
    }).on('mouseleave', function (event) {
        $(this).find('i').html('');
    });
    $('textarea[data-action="handle-tabs"]').on('keydown', function(event) {
        if (event.keyCode === 9) {
            event.preventDefault();

            var curPos = $(this)[0].selectionStart;
            var prepend = $(this).val().substr(0, curPos);
            var append = $(this).val().substr(curPos);

            $(this).val(prepend + '    ' + append);
        }
    });
    $('#pConfigFeatures').select2({
        tags: true,
        selectOnClose: false,
        tokenSeparators: [',', ' '],
    });
    </script>
@endsection

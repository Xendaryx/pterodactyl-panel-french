@extends('layouts.admin')

@section('title')
    Serveur — {{ $server->name }} : Démarrage
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Gérer la commande de démarrage ainsi que les variables.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Administration</a></li>
        <li><a href="{{ route('admin.servers') }}">Serveurs</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Démarrage</li>
    </ol>
@endsection

@section('content')
@include('admin.servers.partials.navigation')
<form action="{{ route('admin.servers.view.startup', $server->id) }}" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Modification de la commande de démarrage</h3>
                </div>
                <div class="box-body">
                    <label for="pStartup" class="form-label">Commande de démarrage</label>
                    <input id="pStartup" name="startup" class="form-control" type="text" value="{{ old('startup', $server->startup) }}" />
                    <p class="small text-muted">Modifiez ici la commande de démarrage du serveur. Les variables suivantes sont disponibles par défaut : <code>@{{SERVER_MEMORY}}</code>, <code>@{{SERVER_IP}}</code> et <code>@{{SERVER_PORT}}</code>.</p>
                </div>
                <div class="box-body">
                    <label for="pDefaultStartupCommand" class="form-label">Commande de démarrage par défaut du service</label>
                    <input id="pDefaultStartupCommand" class="form-control" type="text" readonly />
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary btn-sm pull-right">Enregistrer les modifications</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Configuration du service</h3>
                </div>
                <div class="box-body row">
                    <div class="col-xs-12">
                        <p class="small text-danger">
                            La modification de l’une des valeurs ci-dessous entraînera une réinstallation du serveur. Le serveur sera arrêté avant le lancement de cette opération.
                            Si vous ne souhaitez pas exécuter les scripts d’installation du service, cochez la case correspondante ci-dessous.
                        </p>
                        <p class="small text-danger">
                            <strong>Cette opération peut être destructive dans de nombreux cas. Le serveur sera immédiatement arrêté afin de poursuivre cette action.</strong>
                        </p>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="pNestId">Nid</label>
                        <select name="nest_id" id="pNestId" class="form-control">
                            @foreach($nests as $nest)
                                <option value="{{ $nest->id }}"
                                    @if($nest->id === $server->nest_id)
                                        selected
                                    @endif
                                >{{ $nest->name }}</option>
                            @endforeach
                        </select>
                        <p class="small text-muted no-margin">Sélectionnez le nid dans lequel ce serveur sera regroupé.</p>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="pEggId">Egg</label>
                        <select name="egg_id" id="pEggId" class="form-control"></select>
                        <p class="small text-muted no-margin">Sélectionnez l’Egg qui fournira les paramètres nécessaires au fonctionnement de ce serveur.</p>
                    </div>
                    <div class="form-group col-xs-12">
                        <div class="checkbox checkbox-primary no-margin-bottom">
                            <input id="pSkipScripting" name="skip_scripts" type="checkbox" value="1" @if($server->skip_scripts) checked @endif />
                            <label for="pSkipScripting" class="strong">Ignorer le script d’installation de l’Egg</label>
                        </div>
                        <p class="small text-muted no-margin">Si l’Egg sélectionné possède un script d’installation, celui-ci sera exécuté pendant l’installation. Cochez cette case pour ignorer cette étape.</p>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Configuration de l’image Docker</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pDockerImage">Image Docker</label>
                        <select id="pDockerImage" name="docker_image" class="form-control"></select>
                        <input id="pDockerImageCustom" name="custom_docker_image" value="{{ old('custom_docker_image') }}" class="form-control" placeholder="Ou saisir une image personnalisée..." style="margin-top:1rem"/>
                        <p class="small text-muted no-margin">Il s’agit de l’image Docker utilisée pour exécuter ce serveur. Sélectionnez une image dans la liste ou saisissez une image personnalisée dans le champ ci-dessus.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row" id="appendVariablesTo"></div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    <script>
    function escapeHtml(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    $(document).ready(function () {
        $('#pEggId').select2({placeholder: 'Sélectionner un Egg'}).on('change', function () {
            var selectedEgg = _.isNull($(this).val()) ? $(this).find('option').first().val() : $(this).val();
            var parentChain = _.get(Pterodactyl.nests, $("#pNestId").val());
            var objectChain = _.get(parentChain, 'eggs.' + selectedEgg);

            const images = _.get(objectChain, 'docker_images', [])
            $('#pDockerImage').html('');
            const keys = Object.keys(images);
            for (let i = 0; i < keys.length; i++) {
                let opt = document.createElement('option');
                opt.value = images[keys[i]];
                opt.innerText = keys[i] + " (" + images[keys[i]] + ")";
                if (objectChain.id === parseInt(Pterodactyl.server.egg_id) && Pterodactyl.server.image == opt.value) {
                    opt.selected = true
                }
                $('#pDockerImage').append(opt);
            }
            $('#pDockerImage').on('change', function () {
                $('#pDockerImageCustom').val('');
            })

            if (objectChain.id === parseInt(Pterodactyl.server.egg_id)) {
                if ($('#pDockerImage').val() != Pterodactyl.server.image) {
                    $('#pDockerImageCustom').val(Pterodactyl.server.image);
                }
            }

            if (!_.get(objectChain, 'startup', false)) {
                $('#pDefaultStartupCommand').val(_.get(parentChain, 'startup', 'ERREUR : commande de démarrage non définie !'));
            } else {
                $('#pDefaultStartupCommand').val(_.get(objectChain, 'startup'));
            }

            $('#appendVariablesTo').html('');
            $.each(_.get(objectChain, 'variables', []), function (i, item) {
                var setValue = _.get(Pterodactyl.server_variables, item.env_variable, item.default_value);
                var isRequired = (item.required === 1) ? '<span class="label label-danger">Requis</span> ' : '';
                var dataAppend = ' \
                    <div class="col-xs-12"> \
                        <div class="box"> \
                            <div class="box-header with-border"> \
                                <h3 class="box-title">' + isRequired + escapeHtml(item.name) + '</h3> \
                            </div> \
                            <div class="box-body"> \
                                <input name="environment[' + escapeHtml(item.env_variable) + ']" class="form-control" type="text" id="egg_variable_' + escapeHtml(item.env_variable) + '" /> \
                                <p class="no-margin small text-muted">' + escapeHtml(item.description) + '</p> \
                            </div> \
                            <div class="box-footer"> \
                                <p class="no-margin text-muted small"><strong>Variable de commande de démarrage :</strong> <code>' + escapeHtml(item.env_variable) + '</code></p> \
                                <p class="no-margin text-muted small"><strong>Règles de saisie :</strong> <code>' + escapeHtml(item.rules) + '</code></p> \
                            </div> \
                        </div> \
                    </div>';
                $('#appendVariablesTo').append(dataAppend).find('#egg_variable_' + item.env_variable).val(setValue);
            });
        });

        $('#pNestId').select2({placeholder: 'Sélectionner un nid'}).on('change', function () {
            $('#pEggId').html('').select2({
                data: $.map(_.get(Pterodactyl.nests, $(this).val() + '.eggs', []), function (item) {
                    return {
                        id: item.id,
                        text: item.name,
                    };
                }),
            });

            if (_.isObject(_.get(Pterodactyl.nests, $(this).val() + '.eggs.' + Pterodactyl.server.egg_id))) {
                $('#pEggId').val(Pterodactyl.server.egg_id);
            }

            $('#pEggId').change();
        }).change();
    });
    </script>
@endsection

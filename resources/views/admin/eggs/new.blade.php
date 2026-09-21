@extends('layouts.admin')

@section('title')
    Nids &rarr; Nouvel Egg
@endsection

@section('content-header')
    <h1>Nouvel Egg<small>Créez un nouvel Egg à attribuer aux serveurs.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nests') }}">Nids</a></li>
        <li class="active">Nouvel Egg</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.nests.egg.new') }}" method="POST">
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
                                <label for="pNestId" class="form-label">Nid associé</label>
                                <div>
                                    <select name="nest_id" id="pNestId">
                                        @foreach($nests as $nest)
                                            <option value="{{ $nest->id }}" {{ old('nest_id') != $nest->id ?: 'selected' }}>{{ $nest->name }} &lt;{{ $nest->author }}&gt;</option>
                                        @endforeach
                                    </select>
                                    <p class="text-muted small">Considérez un Nid comme une catégorie. Vous pouvez placer plusieurs Eggs dans un Nid, mais il est recommandé de regrouper uniquement les Eggs ayant un lien entre eux.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pName" class="form-label">Nom</label>
                                <input type="text" id="pName" name="name" value="{{ old('name') }}" class="form-control" />
                                <p class="text-muted small">Un nom simple et lisible servant à identifier cet Egg. Il sera affiché aux utilisateurs comme type de serveur de jeu.</p>
                            </div>
                            <div class="form-group">
                                <label for="pDescription" class="form-label">Description</label>
                                <textarea id="pDescription" name="description" class="form-control" rows="8">{{ old('description') }}</textarea>
                                <p class="text-muted small">Description de cet Egg.</p>
                            </div>
                            <div class="form-group">
                                <div class="checkbox checkbox-primary no-margin-bottom">
                                    <input id="pForceOutgoingIp" name="force_outgoing_ip" type="checkbox" value="1" {{ \Pterodactyl\Helpers\Utilities::checked('force_outgoing_ip', 0) }} />
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
                                <label for="pDockerImage" class="control-label">Images Docker</label>
                                <textarea id="pDockerImages" name="docker_images" rows="4" placeholder="ghcr.io/pterodactyl/yolks" class="form-control">{{ old('docker_images') }}</textarea>
                                <p class="text-muted small">Images Docker disponibles pour les serveurs utilisant cet Egg. Saisissez une image par ligne. Les utilisateurs pourront choisir dans cette liste si plusieurs images sont disponibles.</p>
                            </div>
                            <div class="form-group">
                                <label for="pStartup" class="control-label">Commande de démarrage</label>
                                <textarea id="pStartup" name="startup" class="form-control" rows="10">{{ old('startup') }}</textarea>
                                <p class="text-muted small">Commande de démarrage utilisée par défaut pour les nouveaux serveurs créés avec cet Egg. Elle peut être modifiée individuellement pour chaque serveur si nécessaire.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigFeatures" class="control-label">Fonctionnalités</label>
                                <div>
                                    <select class="form-control" name="features[]" id="pConfigFeatures" multiple>
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
                                <p>Tous les champs sont obligatoires sauf si vous sélectionnez une option dans la liste « Copier les paramètres depuis ». Dans ce cas, les champs peuvent rester vides afin d’utiliser les valeurs de l’option sélectionnée.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFrom" class="form-label">Copier les paramètres depuis</label>
                                <select name="config_from" id="pConfigFrom" class="form-control">
                                    <option value="">Aucun</option>
                                </select>
                                <p class="text-muted small">Pour utiliser par défaut les paramètres d’un autre Egg, sélectionnez-le dans la liste ci-dessus.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStop" class="form-label">Commande d’arrêt</label>
                                <input type="text" id="pConfigStop" name="config_stop" class="form-control" value="{{ old('config_stop') }}" />
                                <p class="text-muted small">Commande envoyée aux processus du serveur pour les arrêter proprement. Si vous devez envoyer un <code>SIGINT</code>, saisissez <code>^C</code> ici.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigLogs" class="form-label">Configuration des journaux</label>
                                <textarea data-action="handle-tabs" id="pConfigLogs" name="config_logs" class="form-control" rows="6">{{ old('config_logs') }}</textarea>
                                <p class="text-muted small">Cette valeur doit être une représentation JSON indiquant où les fichiers journaux sont stockés et si le daemon doit créer des journaux personnalisés.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFiles" class="form-label">Fichiers de configuration</label>
                                <textarea data-action="handle-tabs" id="pConfigFiles" name="config_files" class="form-control" rows="6">{{ old('config_files') }}</textarea>
                                <p class="text-muted small">Cette valeur doit être une représentation JSON des fichiers de configuration à modifier et des éléments devant être modifiés.</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStartup" class="form-label">Configuration du démarrage</label>
                                <textarea data-action="handle-tabs" id="pConfigStartup" name="config_startup" class="form-control" rows="6">{{ old('config_startup') }}</textarea>
                                <p class="text-muted small">Cette valeur doit être une représentation JSON des valeurs que le daemon doit rechercher lors du démarrage d’un serveur afin de déterminer si celui-ci est terminé.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success btn-sm pull-right">Créer</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    <script>
    $(document).ready(function() {
        $('#pNestId').select2().change();
        $('#pConfigFrom').select2();
    });
    $('#pNestId').on('change', function (event) {
        $('#pConfigFrom').html('<option value="">Aucun</option>').select2({
            data: $.map(_.get(Pterodactyl.nests, $(this).val() + '.eggs', []), function (item) {
                return {
                    id: item.id,
                    text: item.name + ' <' + item.author + '>',
                };
            }),
        });
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

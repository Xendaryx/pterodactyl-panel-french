@extends('layouts.admin')

@section('title')
    Serveur — {{ $server->name }} : Configuration des ressources
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Gérer les allocations et les ressources système de ce serveur.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Administration</a></li>
        <li><a href="{{ route('admin.servers') }}">Serveurs</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Configuration des ressources</li>
    </ol>
@endsection

@section('content')
@include('admin.servers.partials.navigation')
<div class="row">
    <form action="{{ route('admin.servers.view.build', $server->id) }}" method="POST">
        <div class="col-sm-5">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Gestion des ressources</h3>
                </div>
                <div class="box-body">
                <div class="form-group">
                        <label for="cpu" class="control-label">Limite CPU</label>
                        <div class="input-group">
                            <input type="text" name="cpu" class="form-control" value="{{ old('cpu', $server->cpu) }}"/>
                            <span class="input-group-addon">%</span>
                        </div>
                        <p class="text-muted small">Chaque cœur <em>virtuel</em> (thread) du système correspond à <code>100%</code>. Définir cette valeur sur <code>0</code> permet au serveur d’utiliser le CPU sans limitation.</p>
                    </div>
                    <div class="form-group">
                        <label for="threads" class="control-label">Affinité CPU</label>
                        <div>
                            <input type="text" name="threads" class="form-control" value="{{ old('threads', $server->threads) }}"/>
                        </div>
                        <p class="text-muted small"><strong>Avancé :</strong> Indiquez les cœurs CPU spécifiques sur lesquels ce processus peut s’exécuter, ou laissez ce champ vide pour autoriser tous les cœurs. Vous pouvez saisir un seul numéro ou une liste séparée par des virgules. Exemple : <code>0</code>, <code>0-1,3</code> ou <code>0,1,3,4</code>.</p>
                    </div>
                    <div class="form-group">
                        <label for="memory" class="control-label">Mémoire allouée</label>
                        <div class="input-group">
                            <input type="text" name="memory" data-multiplicator="true" class="form-control" value="{{ old('memory', $server->memory) }}"/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <p class="text-muted small">Quantité maximale de mémoire autorisée pour ce conteneur. Définir cette valeur sur <code>0</code> autorise une quantité de mémoire illimitée.</p>
                    </div>
                    <div class="form-group">
                        <label for="swap" class="control-label">Mémoire d’échange allouée</label>
                        <div class="input-group">
                            <input type="text" name="swap" data-multiplicator="true" class="form-control" value="{{ old('swap', $server->swap) }}"/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <p class="text-muted small">Définir cette valeur sur <code>0</code> désactive la mémoire d’échange pour ce serveur. La valeur <code>-1</code> autorise une quantité illimitée.</p>
                    </div>
                    <div class="form-group">
                        <label for="cpu" class="control-label">Limite d’espace disque</label>
                        <div class="input-group">
                            <input type="text" name="disk" class="form-control" value="{{ old('disk', $server->disk) }}"/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <p class="text-muted small">Ce serveur ne pourra pas démarrer s’il utilise plus que cette quantité d’espace. S’il dépasse cette limite pendant son fonctionnement, il sera arrêté proprement et verrouillé jusqu’à ce qu’un espace suffisant soit disponible. Définissez <code>0</code> pour autoriser une utilisation illimitée du disque.</p>
                    </div>
                    <div class="form-group">
                        <label for="io" class="control-label">Priorité E/S du bloc</label>
                        <div>
                            <input type="text" name="io" class="form-control" value="{{ old('io', $server->io) }}"/>
                        </div>
                        <p class="text-muted small"><strong>Avancé :</strong> Priorité des performances E/S de ce serveur par rapport aux autres conteneurs <em>en cours d’exécution</em> sur le système. La valeur doit être comprise entre <code>10</code> et <code>1000</code>.</code></p>
                    </div>
                    <div class="form-group">
                        <label for="cpu" class="control-label">OOM Killer</label>
                        <div>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" id="pOomKillerEnabled" value="0" name="oom_disabled" @if(!$server->oom_disabled)checked @endif>
                                <label for="pOomKillerEnabled">Activé</label>
                            </div>
                            <div class="radio radio-success radio-inline">
                                <input type="radio" id="pOomKillerDisabled" value="1" name="oom_disabled" @if($server->oom_disabled)checked @endif>
                                <label for="pOomKillerDisabled">Désactivé</label>
                            </div>
                            <p class="text-muted small">
                                L’activation de l’OOM Killer peut entraîner l’arrêt inattendu de processus du serveur.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Limites des fonctionnalités</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label for="database_limit" class="control-label">Limite de bases de données</label>
                                    <div>
                                        <input type="text" name="database_limit" class="form-control" value="{{ old('database_limit', $server->database_limit) }}"/>
                                    </div>
                                    <p class="text-muted small">Nombre total de bases de données qu’un utilisateur peut créer pour ce serveur.</p>
                                </div>
                                <div class="form-group col-xs-6">
                                    <label for="allocation_limit" class="control-label">Limite d’allocations</label>
                                    <div>
                                        <input type="text" name="allocation_limit" class="form-control" value="{{ old('allocation_limit', $server->allocation_limit) }}"/>
                                    </div>
                                    <p class="text-muted small">Nombre total d’allocations qu’un utilisateur peut créer pour ce serveur.</p>
                                </div>
                                <div class="form-group col-xs-6">
                                    <label for="backup_limit" class="control-label">Limite de sauvegardes</label>
                                    <div>
                                        <input type="text" name="backup_limit" class="form-control" value="{{ old('backup_limit', $server->backup_limit) }}"/>
                                    </div>
                                    <p class="text-muted small">Nombre total de sauvegardes pouvant être créées pour ce serveur.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Gestion des allocations</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="pAllocation" class="control-label">Port principal</label>
                                <select id="pAllocation" name="allocation_id" class="form-control">
                                    @foreach ($assigned as $assignment)
                                        <option value="{{ $assignment->id }}"
                                            @if($assignment->id === $server->allocation_id)
                                                selected="selected"
                                            @endif
                                        >{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                    @endforeach
                                </select>
                                <p class="text-muted small">Adresse de connexion principale utilisée par ce serveur.</p>
                            </div>
                            <div class="form-group">
                                <label for="pAddAllocations" class="control-label">Attribuer des ports supplémentaires</label>
                                <div>
                                    <select name="add_allocations[]" class="form-control" multiple id="pAddAllocations">
                                        @foreach ($unassigned as $assignment)
                                            <option value="{{ $assignment->id }}">{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-muted small">En raison de limitations logicielles, vous ne pouvez pas attribuer des ports identiques sur différentes adresses IP au même serveur.</p>
                            </div>
                            <div class="form-group">
                                <label for="pRemoveAllocations" class="control-label">Retirer des ports supplémentaires</label>
                                <div>
                                    <select name="remove_allocations[]" class="form-control" multiple id="pRemoveAllocations">
                                        @foreach ($assigned as $assignment)
                                            <option value="{{ $assignment->id }}">{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-muted small">Sélectionnez les ports que vous souhaitez retirer dans la liste ci-dessus. Si vous souhaitez attribuer un port sur une autre adresse IP déjà utilisée, sélectionnez-le dans la liste de gauche puis retirez-le ici.</p>
                            </div>
                        </div>
                        <div class="box-footer">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-primary pull-right">Enregistrer la configuration</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#pAddAllocations').select2();
    $('#pRemoveAllocations').select2();
    $('#pAllocation').select2();
    </script>
@endsection

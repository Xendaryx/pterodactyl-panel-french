@extends('layouts.admin')

@section('title')
    Hôtes de bases de données &rarr; Détails &rarr; {{ $host->name }}
@endsection

@section('content-header')
    <h1>{{ $host->name }}<small>Consultez les bases de données associées et les informations de cet hôte.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Administration</a></li>
        <li><a href="{{ route('admin.databases') }}">Hôtes de bases de données</a></li>
        <li class="active">{{ $host->name }}</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.databases.view', $host->id) }}" method="POST">
    <div class="row">
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Informations de l’hôte</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pName" class="form-label">Nom</label>
                        <input type="text" id="pName" name="name" class="form-control" value="{{ old('name', $host->name) }}" />
                    </div>
                    <div class="form-group">
                        <label for="pHost" class="form-label">Hôte</label>
                        <input type="text" id="pHost" name="host" class="form-control" value="{{ old('host', $host->host) }}" />
                        <p class="text-muted small">L’adresse IP ou le nom de domaine complet (FQDN) à utiliser pour se connecter à cet hôte MySQL <em>depuis le panel</em> afin de créer de nouvelles bases de données.</p>
                    </div>
                    <div class="form-group">
                        <label for="pPort" class="form-label">Port</label>
                        <input type="text" id="pPort" name="port" class="form-control" value="{{ old('port', $host->port) }}" />
                        <p class="text-muted small">Port sur lequel MySQL fonctionne pour cet hôte.</p>
                    </div>
                    <div class="form-group">
                        <label for="pNodeId" class="form-label">Nœud associé</label>
                        <select name="node_id" id="pNodeId" class="form-control">
                            <option value="">Aucun</option>
                            @foreach($locations as $location)
                                <optgroup label="{{ $location->short }}">
                                    @foreach($location->nodes as $node)
                                        <option value="{{ $node->id }}" {{ $host->node_id !== $node->id ?: 'selected' }}>{{ $node->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="text-muted small">Ce paramètre permet de sélectionner cet hôte de base de données par défaut lors de l’ajout d’une base de données à un serveur situé sur le nœud sélectionné.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Informations du compte</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pUsername" class="form-label">Nom d’utilisateur</label>
                        <input type="text" name="username" id="pUsername" class="form-control" value="{{ old('username', $host->username) }}" />
                        <p class="text-muted small">Nom d’utilisateur d’un compte disposant des permissions nécessaires pour créer de nouveaux utilisateurs et de nouvelles bases de données sur le système.</p>
                    </div>
                    <div class="form-group">
                        <label for="pPassword" class="form-label">Mot de passe</label>
                        <input type="password" name="password" id="pPassword" class="form-control" />
                        <p class="text-muted small">Mot de passe du compte défini. Laissez ce champ vide pour conserver le mot de passe actuellement configuré.</p>
                    </div>
                    <hr />
                    <p class="text-danger small text-left">Le compte défini pour cet hôte de base de données <strong>doit</strong> disposer de la permission <code>WITH GRANT OPTION</code>. Sans cette permission, les demandes de création de bases de données <em>échoueront</em>. <strong>N’utilisez pas les mêmes identifiants MySQL que ceux configurés pour ce panel.</strong></p>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button name="_method" value="PATCH" class="btn btn-sm btn-primary pull-right">Enregistrer</button>
                    <button name="_method" value="DELETE" class="btn btn-sm btn-danger pull-left muted muted-hover"><i class="fa fa-trash-o"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Bases de données</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>Serveur</th>
                        <th>Nom de la base de données</th>
                        <th>Nom d’utilisateur</th>
                        <th>Connexions depuis</th>
                        <th>Connexions max.</th>
                        <th></th>
                    </tr>
                    @foreach($databases as $database)
                        <tr>
                            <td class="middle"><a href="{{ route('admin.servers.view', $database->getRelation('server')->id) }}">{{ $database->getRelation('server')->name }}</a></td>
                            <td class="middle">{{ $database->database }}</td>
                            <td class="middle">{{ $database->username }}</td>
                            <td class="middle">{{ $database->remote }}</td>
                            @if($database->max_connections != null)
                                <td class="middle">{{ $database->max_connections }}</td>
                            @else
                                <td class="middle">Illimitées</td>
                            @endif
                            <td class="text-center">
                                <a href="{{ route('admin.servers.view.database', $database->getRelation('server')->id) }}">
                                    <button class="btn btn-xs btn-primary">Gérer</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            @if($databases->hasPages())
                <div class="box-footer with-border">
                    <div class="col-md-12 text-center">{!! $databases->render() !!}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('#pNodeId').select2();
    </script>
@endsection

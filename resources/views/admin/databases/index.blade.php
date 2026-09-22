@extends('layouts.admin')

@section('title')
    Hôtes de bases de données
@endsection

@section('content-header')
    <h1>Hôtes de bases de données<small>Hôtes sur lesquels les serveurs peuvent créer leurs bases de données.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Administration</a></li>
        <li class="active">Hôtes de bases de données</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Liste des hôtes</h3>
                <div class="box-tools">
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newHostModal">Créer un hôte</button>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Hôte</th>
                            <th>Port</th>
                            <th>Nom d’utilisateur</th>
                            <th class="text-center">Bases de données</th>
                            <th class="text-center">Nœud</th>
                        </tr>
                        @foreach ($hosts as $host)
                            <tr>
                                <td><code>{{ $host->id }}</code></td>
                                <td><a href="{{ route('admin.databases.view', $host->id) }}">{{ $host->name }}</a></td>
                                <td><code>{{ $host->host }}</code></td>
                                <td><code>{{ $host->port }}</code></td>
                                <td>{{ $host->username }}</td>
                                <td class="text-center">{{ $host->databases_count }}</td>
                                <td class="text-center">
                                    @if(! is_null($host->node))
                                        <a href="{{ route('admin.nodes.view', $host->node->id) }}">{{ $host->node->name }}</a>
                                    @else
                                        <span class="label label-default">Aucun</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="newHostModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.databases') }}" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Créer un nouvel hôte de base de données</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="pName" class="form-label">Nom</label>
                        <input type="text" name="name" id="pName" class="form-control" />
                        <p class="text-muted small">Un identifiant court permettant de distinguer cet hôte des autres. Il doit contenir entre 1 et 60 caractères, par exemple <code>fr.xaryon.db1</code>.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="pHost" class="form-label">Hôte</label>
                            <input type="text" name="host" id="pHost" class="form-control" />
                            <p class="text-muted small">L’adresse IP ou le nom de domaine complet (FQDN) à utiliser pour se connecter à cet hôte MySQL <em>depuis le panel</em> afin de créer de nouvelles bases de données.</p>
                        </div>
                        <div class="col-md-6">
                            <label for="pPort" class="form-label">Port</label>
                            <input type="text" name="port" id="pPort" class="form-control" value="3306"/>
                            <p class="text-muted small">Port sur lequel MySQL fonctionne pour cet hôte.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="pUsername" class="form-label">Nom d’utilisateur</label>
                            <input type="text" name="username" id="pUsername" class="form-control" />
                            <p class="text-muted small">Nom d’utilisateur d’un compte disposant des permissions nécessaires pour créer de nouveaux utilisateurs et de nouvelles bases de données sur le système.</p>
                        </div>
                        <div class="col-md-6">
                            <label for="pPassword" class="form-label">Mot de passe</label>
                            <input type="password" name="password" id="pPassword" class="form-control" />
                            <p class="text-muted small">Mot de passe du compte défini ci-dessus.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pNodeId" class="form-label">Nœud associé</label>
                        <select name="node_id" id="pNodeId" class="form-control">
                            <option value="">Aucun</option>
                            @foreach($locations as $location)
                                <optgroup label="{{ $location->short }}">
                                    @foreach($location->nodes as $node)
                                        <option value="{{ $node->id }}">{{ $node->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="text-muted small">Ce paramètre permet de sélectionner cet hôte de base de données par défaut lors de l’ajout d’une base de données à un serveur situé sur le nœud sélectionné.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <p class="text-danger small text-left">Le compte défini pour cet hôte de base de données <strong>doit</strong> disposer de la permission <code>WITH GRANT OPTION</code>. Sans cette permission, les demandes de création de bases de données <em>échoueront</em>. <strong>N’utilisez pas les mêmes identifiants MySQL que ceux configurés pour ce panel.</strong></p>
                    {!! csrf_field() !!}
                    <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success btn-sm">Créer</button>
                </div>
            </form>
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

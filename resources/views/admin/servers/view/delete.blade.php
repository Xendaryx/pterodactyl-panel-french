@extends('layouts.admin')

@section('title')
    Serveur — {{ $server->name }} : Supprimer
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Supprimer ce serveur du panel.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Administration</a></li>
        <li><a href="{{ route('admin.servers') }}">Serveurs</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Supprimer</li>
    </ol>
@endsection

@section('content')
@include('admin.servers.partials.navigation')
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Supprimer le serveur en toute sécurité</h3>
            </div>
            <div class="box-body">
                <p>Cette action tentera de supprimer le serveur du panel et du daemon. Si l’un des deux signale une erreur, l’opération sera annulée.</p>
                <p class="text-danger small">La suppression d’un serveur est irréversible. <strong>Toutes les données du serveur</strong> (y compris les fichiers et les utilisateurs) seront supprimées du système.</p>
            </div>
            <div class="box-footer">
                <form id="deleteform" action="{{ route('admin.servers.view.delete', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <button id="deletebtn" class="btn btn-danger">Supprimer ce serveur en toute sécurité</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Forcer la suppression du serveur</h3>
            </div>
            <div class="box-body">
                <p>Cette action tentera de supprimer le serveur du panel et du daemon. Si le daemon ne répond pas ou signale une erreur, la suppression se poursuivra.</p>
                <p class="text-danger small">La suppression d’un serveur est irréversible. <strong>Toutes les données du serveur</strong> (y compris les fichiers et les utilisateurs) seront supprimées du système. Cette méthode peut laisser des fichiers résiduels sur votre daemon si celui-ci signale une erreur.</p>
            </div>
            <div class="box-footer">
                <form id="forcedeleteform" action="{{ route('admin.servers.view.delete', $server->id) }}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="force_delete" value="1" />
                    <button id="forcedeletebtn"" class="btn btn-danger">Forcer la suppression de ce serveur</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#deletebtn').click(function (event) {
        event.preventDefault();
        swal({
            title: '',
            type: 'warning',
            text: 'Voulez-vous vraiment supprimer ce serveur ? Cette action est irréversible et toutes les données seront immédiatement supprimées.',
            showCancelButton: true,
            confirmButtonText: 'Supprimer',
            confirmButtonColor: '#d9534f',
            closeOnConfirm: false
        }, function () {
            $('#deleteform').submit()
        });
    });

    $('#forcedeletebtn').click(function (event) {
        event.preventDefault();
        swal({
            title: '',
            type: 'warning',
            text: 'Voulez-vous vraiment supprimer ce serveur ? Cette action est irréversible et toutes les données seront immédiatement supprimées.',
            showCancelButton: true,
            confirmButtonText: 'Supprimer',
            confirmButtonColor: '#d9534f',
            closeOnConfirm: false
        }, function () {
            $('#forcedeleteform').submit()
        });
    });
    </script>
@endsection

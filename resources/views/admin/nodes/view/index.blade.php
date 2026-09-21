@extends('layouts.admin')

@section('title')
    {{ $node->name }}
@endsection

@section('content-header')
    <h1>{{ $node->name }}<small>Aperçu rapide de votre nœud.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Administration</a></li>
        <li><a href="{{ route('admin.nodes') }}">Nœuds</a></li>
        <li class="active">{{ $node->name }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom nav-tabs-floating">
            <ul class="nav nav-tabs">
                <li class="active"><a href="{{ route('admin.nodes.view', $node->id) }}">À propos</a></li>
                <li><a href="{{ route('admin.nodes.view.settings', $node->id) }}">Paramètres</a></li>
                <li><a href="{{ route('admin.nodes.view.configuration', $node->id) }}">Configuration</a></li>
                <li><a href="{{ route('admin.nodes.view.allocation', $node->id) }}">Allocations</a></li>
                <li><a href="{{ route('admin.nodes.view.servers', $node->id) }}">Serveurs</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informations</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <td>Version du daemon</td>
                                <td><code data-attr="info-version"><i class="fa fa-refresh fa-fw fa-spin"></i></code> (Dernière version : <code>{{ $version->getDaemon() }}</code>)</td>
                            </tr>
                            <tr>
                                <td>Informations système</td>
                                <td data-attr="info-system"><i class="fa fa-refresh fa-fw fa-spin"></i></td>
                            </tr>
                            <tr>
                                <td>Nombre total de threads CPU</td>
                                <td data-attr="info-cpus"><i class="fa fa-refresh fa-fw fa-spin"></i></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @if ($node->description)
                <div class="col-xs-12">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            Description du nœud
                        </div>
                        <div class="box-body table-responsive">
                            <pre>{{ $node->description }}</pre>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Supprimer le nœud</h3>
                    </div>
                    <div class="box-body">
                        <p class="no-margin">La suppression d’un nœud est irréversible et entraînera immédiatement son retrait du panel. Aucun serveur ne doit être associé à ce nœud pour pouvoir continuer.</p>
                    </div>
                    <div class="box-footer">
                        <form action="{{ route('admin.nodes.view.delete', $node->id) }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <button type="submit" class="btn btn-danger btn-sm pull-right" {{ ($node->servers_count < 1) ?: 'disabled' }}>Oui, supprimer ce nœud</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Vue d’ensemble</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    @if($node->maintenance_mode)
                    <div class="col-sm-12">
                        <div class="info-box bg-orange">
                            <span class="info-box-icon"><i class="ion ion-wrench"></i></span>
                            <div class="info-box-content" style="padding: 23px 10px 0;">
                                <span class="info-box-text">Ce nœud est en</span>
                                <span class="info-box-number">maintenance</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-sm-12">
                        <div class="info-box bg-{{ $stats['disk']['css'] }}">
                            <span class="info-box-icon"><i class="ion ion-ios-folder-outline"></i></span>
                            <div class="info-box-content" style="padding: 15px 10px 0;">
                                <span class="info-box-text">Espace disque alloué</span>
                                <span class="info-box-number">{{ $stats['disk']['value'] }} / {{ $stats['disk']['max'] }} MiB</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $stats['disk']['percent'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="info-box bg-{{ $stats['memory']['css'] }}">
                            <span class="info-box-icon"><i class="ion ion-ios-barcode-outline"></i></span>
                            <div class="info-box-content" style="padding: 15px 10px 0;">
                                <span class="info-box-text">Mémoire allouée</span>
                                <span class="info-box-number">{{ $stats['memory']['value'] }} / {{ $stats['memory']['max'] }} MiB</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $stats['memory']['percent'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="info-box bg-blue">
                            <span class="info-box-icon"><i class="ion ion-social-buffer-outline"></i></span>
                            <div class="info-box-content" style="padding: 23px 10px 0;">
                                <span class="info-box-text">Nombre total de serveurs</span>
                                <span class="info-box-number">{{ $node->servers_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    function escapeHtml(str) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    (function getInformation() {
        $.ajax({
            method: 'GET',
            url: '/admin/nodes/view/{{ $node->id }}/system-information',
            timeout: 5000,
        }).done(function (data) {
            $('[data-attr="info-version"]').html(escapeHtml(data.version));
            $('[data-attr="info-system"]').html(escapeHtml(data.system.type) + ' (' + escapeHtml(data.system.arch) + ') <code>' + escapeHtml(data.system.release) + '</code>');
            $('[data-attr="info-cpus"]').html(data.system.cpus);
        }).fail(function (jqXHR) {

        }).always(function() {
            setTimeout(getInformation, 10000);
        });
    })();
    </script>
@endsection

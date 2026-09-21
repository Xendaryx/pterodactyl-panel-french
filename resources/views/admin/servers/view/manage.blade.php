@extends('layouts.admin')

@section('title')
    Serveur — {{ $server->name }} : Gestion
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Actions supplémentaires pour gérer ce serveur.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Administration</a></li>
        <li><a href="{{ route('admin.servers') }}">Serveurs</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Gestion</li>
    </ol>
@endsection

@section('content')
    @include('admin.servers.partials.navigation')
    <div class="row equal-height">
        <div class="col-sm-4">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Réinstaller le serveur</h3>
                </div>
                <div class="box-body">
                    <p>Cette action réinstallera le serveur à l’aide des scripts de service attribués. <strong>Attention !</strong> Certaines données du serveur pourraient être écrasées.</p>
                </div>
                <div class="box-footer">
                    @if(! $server->canBeReinstalled())
                        <button class="btn btn-danger disabled">Réinstaller le serveur</button>
                        <p style="padding-top: 1rem;">Ce serveur est configuré pour ignorer son script d’installation. Désactivez « Ignorer le script d’installation de l’Egg » dans la page Démarrage pour pouvoir le réinstaller.</p>
                    @elseif($server->isInstalled())
                        <form action="{{ route('admin.servers.view.manage.reinstall', $server->id) }}" method="POST">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-danger">Réinstaller le serveur</button>
                        </form>
                    @else
                        <button class="btn btn-danger disabled">Le serveur doit être correctement installé pour être réinstallé</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">État de l’installation</h3>
                </div>
                <div class="box-body">
                    <p>Vous pouvez modifier manuellement l’état d’installation du serveur, d’installé à non installé ou inversement, à l’aide du bouton ci-dessous.</p>
                </div>
                <div class="box-footer">
                    <form action="{{ route('admin.servers.view.manage.toggle', $server->id) }}" method="POST">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-primary">Modifier l’état d’installation</button>
                    </form>
                </div>
            </div>
        </div>

        @if(! $server->isSuspended())
            <div class="col-sm-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Suspendre le serveur</h3>
                    </div>
                    <div class="box-body">
                        <p>Cette action suspendra le serveur, arrêtera tous les processus en cours et bloquera immédiatement l’accès de l’utilisateur à ses fichiers ainsi qu’à la gestion du serveur depuis le panel ou l’API.</p>
                    </div>
                    <div class="box-footer">
                        <form action="{{ route('admin.servers.view.manage.suspension', $server->id) }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="action" value="suspend" />
                            <button type="submit" class="btn btn-warning @if(! is_null($server->transfer)) disabled @endif">Suspendre le serveur</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="col-sm-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Réactiver le serveur</h3>
                    </div>
                    <div class="box-body">
                        <p>Cette action réactivera le serveur et rétablira l’accès normal de l’utilisateur.</p>
                    </div>
                    <div class="box-footer">
                        <form action="{{ route('admin.servers.view.manage.suspension', $server->id) }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="action" value="unsuspend" />
                            <button type="submit" class="btn btn-success">Réactiver le serveur</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if(is_null($server->transfer))
            <div class="col-sm-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Transférer le serveur</h3>
                    </div>
                    <div class="box-body">
                        <p>
                            Transférer ce serveur vers un autre nœud connecté à ce panel.
                            <strong>Attention !</strong> Cette fonctionnalité n’a pas été entièrement testée et peut présenter des dysfonctionnements.
                        </p>
                    </div>

                    <div class="box-footer">
                        @if($canTransfer)
                            <button class="btn btn-success" data-toggle="modal" data-target="#transferServerModal">Transférer le serveur</button>
                        @else
                            <button class="btn btn-success disabled">Transférer le serveur</button>
                            <p style="padding-top: 1rem;">Le transfert d’un serveur nécessite qu’au moins deux nœuds soient configurés sur votre panel.</p>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="col-sm-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Transférer le serveur</h3>
                    </div>
                    <div class="box-body">
                        <p>
                            Ce serveur est actuellement en cours de transfert vers un autre nœud.
                            Le transfert a été lancé le <strong>{{ $server->transfer->created_at }}</strong>
                        </p>
                    </div>

                    <div class="box-footer">
                        <button class="btn btn-success disabled">Transférer le serveur</button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="transferServerModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.servers.view.manage.transfer', $server->id) }}" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Transférer le serveur</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="pNodeId">Nœud</label>
                                <select name="node_id" id="pNodeId" class="form-control">
                                    @foreach($locations as $location)
                                        <optgroup label="{{ $location->long }} ({{ $location->short }})">
                                            @foreach($location->nodes as $node)

                                                @if($node->id != $server->node_id)
                                                    <option value="{{ $node->id }}"
                                                            @if($location->id === old('location_id')) selected @endif
                                                    >{{ $node->name }}</option>
                                                @endif

                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <p class="small text-muted no-margin">Le nœud vers lequel ce serveur sera transféré.</p>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="pAllocation">Allocation principale</label>
                                <select name="allocation_id" id="pAllocation" class="form-control"></select>
                                <p class="small text-muted no-margin">L’allocation principale qui sera attribuée à ce serveur.</p>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="pAllocationAdditional">Allocations supplémentaires</label>
                                <select name="allocation_additional[]" id="pAllocationAdditional" class="form-control" multiple></select>
                                <p class="small text-muted no-margin">Allocations supplémentaires à attribuer à ce serveur lors du transfert.</p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        {!! csrf_field() !!}
                        <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success btn-sm">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}

    @if($canTransfer)
        {!! Theme::js('js/admin/server/transfer.js') !!}
    @endif
@endsection

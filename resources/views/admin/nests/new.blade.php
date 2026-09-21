@extends('layouts.admin')

@section('title')
    Nouveau Nid
@endsection

@section('content-header')
    <h1>Nouveau Nid<small>Configurez un nouveau Nid à déployer sur tous les Nœuds.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.nests') }}">Nids</a></li>
        <li class="active">Nouveau</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.nests.new') }}" method="POST">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Nouveau Nid</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label">Nom</label>
                        <div>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" />
                            <p class="text-muted"><small>Choisissez un nom de catégorie descriptif regroupant tous les Eggs contenus dans ce Nid.</small></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Description</label>
                        <div>
                            <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary pull-right">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@extends('admin.layouts.admin')

@section('title', 'Status Page - Create Status Check')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('statuspage.admin.update') }}" method="POST">
{{--                <input type="hidden" name="id" value="{{ $server }}">--}}
                @csrf
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-8 col-lg-4">
                            <label class="form-label" for="name" >{{ trans('messages.fields.name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ $server->name }}" required>

                            @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-md-8 col-lg-4">
                            <label class="form-label" for="host">Host</label>
                            <input class="form-control @error('host') is-invalid @enderror"
                                   id="host" name="host" value="{{ $server->host }}" required>
                            @error('host')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <label class="form-label" for="port">Port</label>
                            <input class="form-control @error('port') is-invalid @enderror"
                                   id="port" name="port" value="{{ $server->port }}" required>

                            @error('port')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="col-md-4 col-lg-2">
                            <label class="form-label" for="type">Check Type</label>
                            <select class="form-select @error('type') is-invalid @enderror"
                                    id="type" name="type">
                                <option value="java" @if($server->type == 'java') selected @endif>Java</option>
                                <option value="bedrock" @if($server->type == 'bedrock') selected @endif>Bedrock</option>
                            </select>
                            @error('type')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

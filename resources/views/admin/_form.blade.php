@csrf

<div class="mb-3">
    <label class="form-label" for="name">{{ trans('messages.fields.name') }}</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror"
           id="name" name="name"  required>

    @error('name')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="row">
    <div class="col-md-8 col-lg-8">
        <label class="form-label" for="host">Host</label>
        <input class="form-control @error('host') is-invalid @enderror"
               id="host" name="host">

        @error('host')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-4 col-lg-2">
        <label class="form-label" for="port">Port</label>
        <input class="form-control @error('port') is-invalid @enderror"
               id="port" name="port">

        @error('port')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-4 col-lg-2">
        <label class="form-label" for="type">Check Type</label>
        <select class="form-select @error('type') is-invalid @enderror"
               id="type" name="type">
            <option value="java">Java</option>
            <option value="bedrock">Bedrock</option>
        @error('type')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

@extends('admin.layouts.admin')

@section('title', 'Admin plugin home')
@push('footer-scripts')
    <script src="{{ asset('vendor/sortablejs/Sortable.min.js') }}"></script>
    <script>
        const sortable = Sortable.create(document.getElementById('statusMembers'), {
            animation: 150,
            group: 'statusMembers',
            handle: '.sortable-handle'
        });

        function serialize(sortable) {
            return [].slice.call(sortable.children).map(function (child) {
                return child.dataset['id'];
            });
        }

        const saveButton = document.getElementById('save');
        const saveButtonIcon = saveButton.querySelector('.btn-spinner');

        saveButton.addEventListener('click', function () {
            saveButton.setAttribute('disabled', '');
            saveButtonIcon.classList.remove('d-none');

            axios.post('{{ route('statuspage.admin.update-order') }}', {
                'statusMembers': serialize(sortable.el),
            }).then(function (json) {
                createAlert('success', json.data.message, true);
            }).catch(function (error) {
                createAlert('danger', error.response.data.message ? error.response.data.message : error, true)
            }).finally(function () {
                saveButton.removeAttribute('disabled');
                saveButtonIcon.classList.add('d-none');
            });
        });
    </script>
@endpush
@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">

            @empty($checks)
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle"></i> There are no status checks yet.
                </div>
            @else
                <ol class="list-unstyled sortable mb-3" id="statusMembers">
                    @foreach($checks as $check)
{{--                        <pre>@php var_dump($check) @endphp</pre>--}}
                        <li class="sortable-item sortable-dropdown" data-id="{{ $check->id }}">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between" @if(!$check->is_enabled) style="color: var(--bs-danger) !important;" @endif>
                                    <span>
                                        <i class="bi bi-arrows-move sortable-handle"></i>
                                        <a href="{{ route('statuspage.admin.index') }}#{{ Str::slug($check->id) }}" @if(!$check->is_enabled) style="color: var(--bs-danger) !important;"  @endif target="_blank">
                                            {{ $check->name }}
                                        </a>
                                    </span>
                                    <span>
                                        @if (!$check->is_enabled)
                                            <a href="{{ route('statuspage.admin.enable', $check) }}" class="m-1" title="Enable site" data-bs-toggle="tooltip"><i class="bi bi-check-square-fill" style="color: var(--bs-danger) !important;"></i></a>
                                        @else
                                            <a href="{{ route('statuspage.admin.disable', $check) }}" class="m-1" title="Disable site" data-bs-toggle="tooltip"><i class="bi bi-x-square-fill"></i></a>
                                        @endif
                                        <a href="{{ route('statuspage.admin.edit', $check )}}" class="m-1" title="{{ trans('messages.actions.edit') }}" data-bs-toggle="tooltip"><i class="bi bi-pencil-square"  @if(!$check->is_enabled) style="color: var(--bs-danger) !important;"  @endif ></i></a>
                                        <a href="{{ route('statuspage.admin.destroy', $check) }}" class="m-1" title="{{ trans('messages.actions.delete') }}" data-bs-toggle="tooltip" data-confirm="delete"><i class="bi bi-trash"  @if(!$check->is_enabled) style="color: var(--bs-danger) !important;"  @endif ></i></a>
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>

                <button type="button" class="btn btn-success" id="save">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                    <span class="spinner-border spinner-border-sm btn-spinner d-none" role="status"></span>
                </button>
            @endempty

            <a class="btn btn-primary" href="{{ route('statuspage.admin.create') }}">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a>
        </div>
    </div>
@endsection

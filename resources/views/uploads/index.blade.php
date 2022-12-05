@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            @include('errorMessage.index')
            <div class="card border-0 shadow rounded">
                <div class="card-body">
                    <a href="/uploads/create" class="btn btn-md btn-success mb-3">Uploads image</a>
                    <div class="d-flex" style="gap: 10px">
                        @forelse($uploadsMimeSize as $val)
                        <h4>{{$val->mime}}: size = {{$val->size}} KB. , Items = {{$val->countItem}}</h4>
                        @empty
                        <div class="alert alert-danger">
                            No data.
                        </div>
                        @endforelse

                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Image</th>
                                <th scope="col">Mime</th>
                                <th scope="col">Size</th>
                                <th scope="col">Created date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $index = 1; ?>
                            @forelse ($uploads as $val)
                            <tr>
                                <td class="align-middle">{{$index++}}</td>
                                <td class="text-center align-middle">
                                    <img src="{{ Storage::url('public/uploads/'.$val->userId.'/').$val->image }}" class="rounded" style="width: 150px">
                                </td>
                                <td class="align-middle">{{ $val->mime }}</td>
                                <td class="align-middle">{{$val->size}}</td>
                                <td class="align-middle">{{$val->created_at}}</td>
                                <td class="text-center align-middle">
                                    <form onsubmit="return confirm('Confirm delete ?');" action="/uploads/destroy/{{$val->id}}" method="POST">
                                        <a href="/uploads/edit/{{$val->id}}" class="btn btn-sm btn-primary">EDIT</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <div class="alert alert-danger">
                                No data.
                            </div>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $uploads->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    //message with toastr
    // @if(session()->has('success'))

    // toastr.success('{{ session('
    //     success ') }}', 'BERHASIL!');

    // @elseif(session()->has('error'))

    // toastr.error('{{ session('
    //     error ') }}', 'GAGAL!');

    // @endif
</script>
@endsection
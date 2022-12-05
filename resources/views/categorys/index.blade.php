@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            @include('errorMessage.index')
            <div class="card border-0 shadow rounded">
                <div class="card-body">
                    <a href="/uploads/create" class="btn btn-md btn-success mb-3">Add category</a>
                    <div class="d-flex" style="gap: 10px">
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category name</th>
                                <th scope="col">Category image amount</th>
                                <th scope="col">Category image size(KB.)</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $index = 1; ?>
                            @forelse ($categorys as $val)
                            <tr>
                                <td class="align-middle">{{$index++}}</td>
                                <td class="align-middle">{{ $val->categoryName }}</td>
                                <td class="align-middle">{{$val->countItemAll}}</td>
                                <td class="align-middle">{{$val->sumSizeAll}}</td>
                                <td class="align-middle">{{$val->created_at}}</td>
                                <td class="text-center align-middle">
                                    <form onsubmit="return confirm('Confirm delete ?');" action="/categorys/destroy/{{$val->id}}" method="POST">
                                        <a href="/categorys/edit/{{$val->id}}" class="btn btn-sm btn-primary">EDIT</a>
                                        <a href="/category-relation/view/{{$val->id}}" class="btn btn-sm btn-primary">View category</a>
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
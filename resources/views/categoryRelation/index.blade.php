@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            @include('errorMessage.index')
            <div class="card border-0 shadow rounded">
                <div class="card-body">
                    <!-- <a href="/uploads/create" class="btn btn-md btn-success mb-3">Add category</a> -->
                    <h3>My category</h3>
                    <div style="max-height: 60vh; overflow-y: scroll;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Category name</th>
                                    <th scope="col">image order</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Mime</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Created date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $index = 1; ?>
                                @forelse ($categoryRelation as $val)
                                <tr>
                                    <td class="align-middle">{{$index++}}</td>
                                    <td scope="col" class="align-middle">{{ $val->categoryName }}</td>
                                    <td scope="col" class="align-middle text-center">
                                        <!-- {{ $val->orderShow }} -->
                                        <form onsubmit="" id="formUpdateOrderShow{{$val->id}}" action="/category-relation/update/{{$val->id}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="orderShow" onchange="handleOrderShow('formUpdateOrderShow{{$val->id}}')">
                                                @if(empty($val->orderShow))
                                                <option selected value="">ยังไม่เลือกลำดับแสดง</option>
                                                @endif
                                                @for($i = 1; $i <= count($categoryRelation); $i++) <option {{$i == $val->orderShow ? 'selected' : ''}} value="{{$i}}">{{$i}}</option>
                                                    @endfor
                                            </select>

                                        </form>

                                    </td>
                                    <td class="text-center align-middle">
                                        <img src="{{ Storage::url('public/uploads/'.$val->userId.'/').$val->image }}" class="rounded" style="width: 150px">
                                    </td>
                                    <td class="align-middle">{{ $val->mime }}</td>
                                    <td class="align-middle">{{$val->size}}</td>
                                    <td class="align-middle">{{$val->created_at}}</td>
                                    <td class="text-center align-middle">
                                        <form onsubmit="return confirm('Confirm delete ?');" action="/category-relation/destroy/{{$val->id}}" method="POST">
                                            <!-- <a href="/uploads/edit/{{$val->id}}" class="btn btn-sm btn-primary">EDIT</a> -->
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

                    <h3>Image uploads</h3>
                    <div style="max-height: 60vh; overflow-y: scroll;">
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
                                        <form onsubmit="return confirm('Confirm add ?');" action="/category-relation/store" method="POST">
                                            <!-- <a href="/category-relation/edit/{{$val->id}}" class="btn btn-sm btn-primary">EDIT</a> -->
                                            <input type="hidden" name="categoryId" value="{{$categoryId}}">
                                            <input type="hidden" name="uploadId" value="{{$val->id}}">
                                            @csrf
                                            <!-- @method('DELETE') -->
                                            <button type="submit" class="btn btn-sm btn-primary">Add to category</button>
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
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    const handleOrderShow = (formId) => {
        const formUpdateOrderShow = document.getElementById(formId);
        formUpdateOrderShow.submit();
    }
</script>
@endsection
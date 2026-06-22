@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')

    <div class="row">
        <div class="col-8">
            {{-- 1. Add a category form --}}
            <form action="{{ route('admin.categories.store') }}" method="post" class="mb-4">
                @csrf
                <div class="row gx-2">
                    <div class="col-9">
                        <input type="text" name="name" class="form-control" placeholder="Add a category"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-danger small mb-0">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary btn-md">
                            <i class="fa-solid fa-plus"></i> Add
                        </button>
                    </div>
                </div>
            </form>

            {{-- 2. CATEGORIES TABLE --}}
            <table class="table table-hover align-middle bg-white border text-secondary text-center">
                <thead class="table-warning text-secondary">
                    <tr>
                        <th>#</th>
                        <th>NAME</th>
                        <th>COUNT</th>
                        <th>LAST UPDATED</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all_categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->categoryPost->count() }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-warning btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#edit-category-{{ $category->id }}">
                                    <i class="fa-solid fa-pen text-warning"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#delete-category-{{ $category->id }}">
                                    <i class="fa-regular fa-trash-can text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        {{-- include modal --}}
                        @include('admin.categories.modals.status')
                    @endforeach

                    {{-- 3.UNCATEGORIZED TABLE --}}
                    <tr class="bg-light">
                        <td></td>
                        <td class="text-dark fw-bold text-center">
                            Uncategorized<br>
                            <small class="text-muted fw-normal">Hidden posts are not
                                included.</small>
                        </td>
                        <td>{{ $uncategorized_count }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

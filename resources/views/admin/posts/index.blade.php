@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-primary text-secondary">
            <tr>
                <th></th>
                <th></th>
                <th>CATEGORY</th>
                <th>OWNER</th>
                <th>CREATED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_posts as $post)
                <tr>
                    {{-- 1. ID --}}
                    <td>{{ $post->id }}</td>

                     {{-- 2.IMAGE --}}
                     <td><img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="admin-img"></td>

                    {{-- 3. CATEGORY --}}
                    <td>
                        @foreach ($post->categoryPost as $category_post)
                            <div class="badge bg-secondary bg-opacity-50">
                                {{ $category_post->category->name }}
                            </div>
                        @endforeach
                        @if ($post->categoryPost->isEmpty())
                            <span class="badge bg-dark text-white">Uncategorized</span>
                        @endif
                    </td>
                    {{-- 4.OWENER --}}
                    <td>
                        <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">
                            {{ $post->user->name }}
                        </a>
                    </td>

                    {{-- 5. CREATED AT --}}
                    <td>{{ $post->created_at }}</td>

                    {{-- 6. STATUS --}}
                    <td>
                        @if ($post->trashed())
                            <i class="fa-solid fa-circle text-secondary"></i> &nbsp; Hidden
                        @else
                            <i class="fa-solid fa-circle text-primary"></i> &nbsp; Visible
                        @endif
                    </td>

                    {{-- 7. DROPDOWN & MODAL --}}
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <div class="dropdown-menu">
                                @if ($post->trashed())
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#visible-post-{{ $post->id }}">
                                        <i class="fa-solid fa-eye"></i> Unhide Post {{ $post->id }}
                                    </button>
                                @else
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal"
                                        data-bs-target="#hidden-post-{{ $post->id }}">
                                        <i class="fa-solid fa-eye-slash"></i> Hide Post {{ $post->id }}
                                    </button>
                                @endif
                            </div>
                        </div>
                        @include('admin.posts.modals.status')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection

@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
            <form action="{{ route('profile.update') }}" method="post" class="bg-white shadow rounded-3 p-5" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <h2 class="h3 mb-3 fw-light text-muted">Update Profile</h2>

                <div class="row mb-3">
                    <div class="col-4">
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                class="img-thumbnail rounded-circle d-block mx-auto avatar-lg">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
                        @endif
                    </div>
                    <div class="col-auto align-self-end">
                        <input type="file" name="avatar" id="avatar" class="form-control form-control-sm mt-1"
                            aria-describedby="avatar-info">
                        <div id="avatar-info" class="form-text">
                            Acceptable formats: jpeg, jpg, png, gif only <br>
                            Max file size is 1048kb
                        </div>
                        {{-- Error --}}
                        @error('avatar')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" autofocus>
                    {{-- Error --}}
                    @error('name')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">E-Mail Address</label>
                    <input type="text" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" autofocus>
                    {{-- Error --}}
                    @error('email')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="introduction" class="form-label fw-bold">Introduction</label>
                    <textarea name="introduction" id="introduction" rows="5" class="form-control" placeholder="Describe yourself">{{ old('introduction', $user->introduction) }}</textarea>
                    {{-- Error --}}
                    @error('introduction')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning px-5">Save</button>
            </form>
        </div>
    </div>
@endsection





















{{-- @extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8 col-lg-6">

                <div class="card edit-card shadow-lg">
                    <div class="card-body p-0 mb-4">
                        <h2 class="edit-title text-start text-secondary fw-bold"> Update Profile</h2>
                    </div>


                    写真とimg選択を横一列
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row align-items-center mb-4">
                            <div class="col-auto">
                                @if ($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                        class="img-thumbnail rounded-circle avatar-lg"> --}}
                                {{-- @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-lg"></i>
                                @endif
                            </div>

                            <div class="col">
                                <input type="file" name="avatar" class="form-control form-control-sm">
                                <div class="text-muted small mt-1">
                                    Acceptable formats:jpeg,jpg,png,if only<br>
                                    Max file size 1048kb
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="mmm">
                            {{-- {{ $user->name }} --}}
                        {{-- </div>

                        <div class="mb-2">
                            <label class="form-label">E-Mail Address</label> --}}
                            {{-- <input type="email" name="email" class="form-control" value="mmm"> --}}
                            {{-- {{ $user->email }} --}}
                        {{-- </div>

                        <div class="mb-2">
                            <label class="form-label">Introduction</label>
                            <textarea name="introduction" class="form-control" rows="4" placeholder="Describe yourself"> --}}
                                {{-- {{ $profile->message ?? '' }} --}}
                            {{-- </textarea>
                        </div> --}}

                        {{-- button --}}
                        {{-- <div class="d-flex gap-3 mb-3 mt-4">
                            <button type="submit" class="btn btn-warning  text-dark btn-sm">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection --}}

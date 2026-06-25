@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
            <form action="{{ route('profile.update') }}" method="post" class="bg-white shadow rounded-3 p-5"
                enctype="multipart/form-data">
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
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $user->name) }}" autofocus>
                    {{-- Error --}}
                    @error('name')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">E-Mail Address</label>
                    <input type="text" name="email" id="email" class="form-control"
                        value="{{ old('email', $user->email) }}" autofocus>
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

                {{-- Profile Colors  masa追加しました↓ --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Profile Colors</label>
                    <div class="d-flex gap-3 align-items-center" id="color-pickers">
                        @foreach (auth()->user()->profile_colors ?? ['#667eea', '#764ba2'] as $i => $color)
                            <div class="d-flex flex-column align-items-center gap-1">
                                <input type="color" name="profile_colors[]" value="{{ $color }}"
                                    style="width:48px;height:48px;border:none;border-radius:8px;cursor:pointer;padding:2px;">
                                {{-- 全部にボタンを置く。1個目だけ visibility:hidden で非表示（高さは確保） --}}
                                <button type="button" onclick="this.closest('div').remove(); updatePreview()"
                                    style="font-size:11px;color:#999;border:none;background:none;cursor:pointer;
                           visibility: {{ $i === 0 ? 'hidden' : 'visible' }};">
                                    削除
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-color" class="btn btn-sm btn-outline-secondary mt-2">+ Add Color（max
                        3）</button>
                    <div id="gradient-preview"
                        style="margin-top:10px;height:50px;border-radius:8px;transition:background 0.4s;"></div>
                </div>

                <script>
                    function updatePreview() {
                        const colors = [...document.querySelectorAll('#color-pickers input[type=color]')].map(i => i.value);
                        document.getElementById('gradient-preview').style.background =
                            `linear-gradient(135deg, ${colors.join(', ')})`;
                    }

                    document.getElementById('color-pickers').addEventListener('input', updatePreview);
                    updatePreview();

                    document.getElementById('add-color').addEventListener('click', () => {
                        const pickers = document.getElementById('color-pickers');
                        if (pickers.children.length >= 3) return;
                        const div = document.createElement('div');
                        div.className = 'd-flex flex-column align-items-center gap-1';
                        div.innerHTML = `
        <input type="color" name="profile_colors[]" value="#f093fb"
               style="width:48px;height:48px;border:none;border-radius:8px;cursor:pointer;padding:2px;">
        <button type="button" onclick="this.closest('div').remove(); updatePreview()"
                style="font-size:11px;color:#999;border:none;background:none;cursor:pointer;">削除</button>`;
                        pickers.appendChild(div);
                        div.querySelector('input').addEventListener('input', updatePreview);
                        updatePreview();
                    });
                </script>
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

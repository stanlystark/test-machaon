@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route("makeLink") }}" method="post">
            @csrf
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <label for="link" class="form-label">Ссылка</label>
                    <div class="input-group mb-3">
                        <input type="text" name="url" {{ Session::get('shortened') ? "readonly" : "" }} class="form-control" value="{{ old("url") }}">
                        @if (!Session::get('shortened'))
                        <button class="btn btn-outline-secondary" type="submit" id="link">Сократить</button>
                        @endif
                    </div>
                </div>
            </div>
            @if ($errors->any())
            <div class="row justify-content-center mb-3">
                <div class="col-12 col-md-6">
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            @if(Session::get('shortened'))
            <div class="row justify-content-center mb-5">
                <div class="col-12 col-md-6">
                    <label for="url" class="form-label">Ваша сокращённая ссылка</label>
                    <input type="text" class="form-control" onClick="this.select();" readonly id="url" value="{{ request()->getSchemeAndHttpHost() }}/{{ Session::get('shortened') }}">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <a class="btn btn-light" href="/">Сократить ещё</a>
                </div>
            </div>
            @endif
        </form>
    </div>
@endsection

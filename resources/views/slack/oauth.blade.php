@extends('layouts.landing')

@section('content')
    <p class="text-align:center;">
        <img
            src="/images/zaengle.gif"
            alt="zaengle animation"></p>
    <div class="text-align:center">
        <form
            method="post"
            action="/oauth/validate-installation"
            enctype="multipart/form-data"
        >
            {{ csrf_field() }}
            <div class="form-group row align-items:center">
                <label
                    for="verifyCode"
                    class="mx-auto font-large"
                >
                    {{$header}}
                </label>
                <div class="col-sm-9">
                    <input
                        name="code"
                        type="text"
                        class="form-control p-3 m-auto"
                        id="verifyCode"
                        placeholder="000000"
                    >
                </div>
                @error('code')
                <div class="text-red-500">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group row">
                <div class="offset-sm-3 col-sm-9">
                    <button
                        type="submit"
                        class="btn btn-xs mx-auto my-2 rounded shadow-xl text-black block px-4 py-2 text-sm bg-white"
                    >
                        Submit Code
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

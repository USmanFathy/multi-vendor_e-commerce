<x-front-layout title="Login">

    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" method="post" action="{{route('two-factor.login')}}">
                        @csrf
                        <div class="card-body">

                            <div class="title">
                                <h3>two factor confirm</h3>
                                <p>please put two factory code.</p>
                            </div>

                            @if($errors->has('code'))
                                <div class="alert alert-danger">
                                    {{$errors->first('code')}}
                                </div>
                            @endif
                            <div class="form-group input-group">
                                <label for="reg-fn">two-factor code</label>
                                <input class="form-control" type="text" name="code" id="reg-email" >
                            </div>
                            <div class="form-group input-group">
                                <label for="reg-fn">Recovery code</label>
                                <input class="form-control" type="text" name="recovery_code" id="reg-email" >
                            </div>

                            <div class="button">
                                <button class="btn" type="submit">submit</button>
                            </div>
                            @if(Route::has('register'))
                            <p class="outer-link">Don't have an account? <a href="{{route('register')}}">Register here </a>
                                @endif
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-front-layout>

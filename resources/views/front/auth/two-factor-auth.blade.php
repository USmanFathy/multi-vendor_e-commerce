<x-front-layout title="Two-Factor Authentication">
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    @if(!auth()->user()->two_factor_secret)
                    <form class="card login-form" method="post" action="{{route('two-factor.enable')}}">
                        @csrf
                        <div class="card-body">

                            <div class="title">
                                <h3>Two-Factor Authentication</h3>
                                <p>You can enable two-factor authentication </p>
                            </div>
                            @if(session('status') == 'two-factor-authentication-enabled')
                                <div class="mb-4 font-medium text-sm">
                                    please finish configuring two factor authentication below
                                </div>
                            @endif
                           <div class="button">
                                <button class="btn" type="submit">Enable</button>
                            </div>

                        </div>
                    </form>
                    @else
                    <form class="card login-form" method="post" action="{{route('two-factor.disable')}}">
                        @csrf
                        @method('delete')
                        <div class="card-body">

                            <div class="title">
                                <h3>Two-Factor Authentication</h3>
                                <p>You can disable two-factor authentication </p>
                            </div>
                            {!! auth()->user()->twoFactorQrCodeSvg(); !!}
                            <h3>Recovery codes</h3>
                            <ul>
                                @foreach(auth()->user()->recoveryCodes() as $code)
                                    <li>{{$code}}</li>
                                @endforeach
                            </ul>
                            <div class="button">
                                <button class="btn" type="submit">Disable</button>
                            </div>

                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-front-layout>

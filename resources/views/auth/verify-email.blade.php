<x-guest-layout>
    <!--begin::Page bg image-->
    <style>body { background-image: url('/assets/media/auth/bg5.jpg'); } [data-bs-theme="dark"] body { background-image: url('/assets/media/auth/bg5-dark.jpg'); }</style>
    <!--end::Page bg image-->
    <!--begin::Authentication - Signup Welcome Message -->
    <div class="d-flex flex-column flex-center flex-column-fluid">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center text-center p-10">
            <!--begin::Wrapper-->
            <div class="card card-flush w-lg-650px py-5">
                <div class="card-body py-15 py-lg-20">
                    <!--begin::Logo-->
                    <div class="mb-14">
                        <a href="{{ route('dashboard') }}" class="">
                            <img alt="Logo" src="{{ asset("assets/media/logos/logo.png") }}" class="h-40px" />
                        </a>
                    </div>
                    <!--end::Logo-->
                    <!--begin::Title-->
                    <h1 class="fw-bolder text-gray-900 mb-5">Verify your email</h1>
                    <!--end::Title-->
                    <!--begin::Action-->
                    <div class="fs-6 mb-8">
                        <span class="fw-semibold text-gray-500">Did’t receive an email?</span>
                        <form method="POST" action="{{ route('verification.send') }}" class="d-inline-block">
                            @csrf

                            <a href="javascript:void(0)" onclick="((elm) => elm.form.submit())(elm)" class="link-primary fw-bold">{{ __('Resend Verification Email') }}</a>
                        </form>

                    </div>
                    <!--end::Action-->
                    <!--begin::Link-->
                    <div class="mb-11">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="javascript:void(0)" onclick="this.form.submit()" class="btn btn-sm btn-primary">{{ __('Log Out') }}</a>
                        </form>

                    </div>
                    <!--end::Link-->
                    <!--begin::Illustration-->
                    <div class="mb-0">
                        <img src="{{ asset("assets/media/auth/please-verify-your-email.png") }}" class="mw-100 mh-300px theme-light-show" alt="" />
                        <img src="{{ asset("assets/media/auth/please-verify-your-email-dark.png") }}" class="mw-100 mh-300px theme-dark-show" alt="" />
                    </div>
                    <!--end::Illustration-->
                </div>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
</x-guest-layout>

{{--<x-guest-layout>--}}
{{--    <div class="mb-4 text-sm text-gray-600">--}}
{{--        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}--}}
{{--    </div>--}}

{{--    @if (session('status') == 'verification-link-sent')--}}
{{--        <div class="mb-4 font-medium text-sm text-green-600">--}}
{{--            {{ __('A new verification link has been sent to the email address you provided during registration.') }}--}}
{{--        </div>--}}
{{--    @endif--}}

{{--    <div class="mt-4 flex items-center justify-between">--}}
{{--        <form method="POST" action="{{ route('verification.send') }}">--}}
{{--            @csrf--}}

{{--            <div>--}}
{{--                <x-primary-button>--}}
{{--                    {{ __('Resend Verification Email') }}--}}
{{--                </x-primary-button>--}}
{{--            </div>--}}
{{--        </form>--}}

{{--        <form method="POST" action="{{ route('logout') }}">--}}
{{--            @csrf--}}

{{--            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">--}}
{{--                {{ __('Log Out') }}--}}
{{--            </button>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--</x-guest-layout>--}}

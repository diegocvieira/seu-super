<!DOCTYPE html>
<html lang="pt-br">
    <head>
    	<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    	<title>{{ $headerTitle ?? 'NoSuper' }}</title>

        <base href="{{ url('/') }}">
        <link rel="canonical" href="{{ $headerCanonical ?? url()->current() }}" />
    	<link rel="shortcut icon" href="{{ asset('images/icon-infochat.png') }}">
    	<meta name="theme-color" content="#43b02a">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    	<!-- SEO META TAGS -->
    	@if (isset($headerKeywords))
    		<meta name="keywords" content="{{ $headerKeywords }}" />
    	@else
    		<meta name="keywords" content="nosuper, produtos, produto, super, mercados, mercado, supermercados, supermercado" />
    	@endif

    	<meta name="description" content="{{ $headerDescription ?? 'O atendimento online da sua cidade.' }}" />
    	<meta itemprop="name" content="{{ $headerTitle ?? 'NoSuper' }}" />
    	<meta itemprop="description" content="{{ $headerDescription ?? 'O atendimento online da sua cidade.' }}" />
    	<meta itemprop="image" content="{{ $headerImage ?? asset('images/social-infochat.png') }}" />

    	<meta name="twitter:card" content="summary_large_image" />
    	<meta name="twitter:title" content="{{ $headerTitle ?? 'NoSuper' }}" />
    	<meta name="twitter:description" content="{{ $headerDescription ?? 'O atendimento online da sua cidade.' }}" />
    	<!-- imagens largas para o Twitter Summary Card precisam ter pelo menos 280x150px  -->
    	<meta name="twitter:image" content="{{ $headerImage ?? asset('images/social-infochat.png') }}" />

    	<meta property="og:title" content="{{ $headerTitle ?? 'NoSuper' }}" />
    	<meta property="og:type" content="website" />
    	<meta property="og:url" content="{{ url()->current() }}" />
    	<meta property="og:image" content="{{ $headerImage ?? asset('images/social-infochat.png') }}" />
        <meta property="og:image:secure_url" content="{{ $headerImage ?? asset('images/social-infochat.png') }}" />
        <meta property="og:description" content="{{ $headerDescription ?? 'O atendimento online da sua cidade.' }}" />
    	<meta property="og:site_name" content="NoSuper" />
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">

        <style>body{opacity:0;}</style>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.8.1/css/bulma.min.css">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"> -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet">

        @if (Agent::isMobile())
            <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
            <link rel="stylesheet" type="text/css" href="{{ mix('css/app-mobile.css') }}">
        @else
            <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
        @endif
    </head>
    <body class="{{ $body_class ?? '' }}">
        @yield ('content')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.min.js"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script> -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <?php /*<script>
            @if (Auth::guard('user')->check())
                var user_logged = true;
            @else
                var user_logged = false;
            @endif
        </script>*/ ?>

        @if (Agent::isMobile())
            <script src="{{ mix('js/app-mobile.js') }}"></script>
        @else
            <script src="{{ mix('js/app.js') }}"></script>
        @endif

        @if (session('session_flash'))
            <script>
                modalAlert("{!! session('session_flash') !!}");
            </script>
        @endif

        @yield ('script')
    </body>
</html>

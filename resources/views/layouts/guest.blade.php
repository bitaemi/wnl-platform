<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<meta property="og:url" content="{{env('APP_URL')}}">
		<meta property="og:type" content="website">
		<meta property="og:title" content="@lang('common.app-title')">
		<meta property="og:description" content="Wypróbuj naszą platformę demo! Wejdź na demo.wiecejnizlek.pl i sprawdź, co czeka Cię na kursie!">
		<meta property="og:image" content="https://wiecejnizlek.pl/wp-content/themes/wiecejnizlek/assets/fb_og_mainpage.png">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>@lang('common.app-title')</title>

		<link rel="icon" href="{{ url('favicon.png') }}">

		<!-- Styles -->
		<link href="{{ mix('css/app.css') }}" rel="stylesheet">

		<!-- Scripts -->
		<script>
			window.Laravel = <?php echo json_encode([
					'csrfToken' => csrf_token(),
			]); ?>
		</script>
		@include('tracking')
	</head>
	<body data-base="{{ env('APP_URL') }}">
		<div id="app">
			<nav class="nav has-shadow">
				<div class="container">
					<div class="nav-left">
						<a class="nav-item" href="https://wiecejnizlek.pl">
							<img src="{{ asset('/images/wnl-logo.svg') }}" alt="Logo Więcej niż LEK">
						</a>
					</div>

					<span class="nav-toggle">
						<span></span>
						<span></span>
						<span></span>
					</span>

					<div class="nav-right nav-menu">
						<form method="post" action="/logout" id="logout-form">
							{{ csrf_field() }}
						</form>
						<a href="@lang('common.course-website-link')" class="nav-item">
							@lang('payment.back-to-website')
						</a>
						@if (Auth::check())
							<a href="{{url('app/myself/orders')}}" class="nav-item">
								Twoje zamówienia
							</a>
							<a href="#" class="nav-item logout-link">
								Wyloguj się
							</a>
						@else
							@if (env('APP_ENV') !== 'demo')
								<a href="{{url('payment/select-product')}}" class="nav-item">
									Zapisz się na kurs
								</a>
							@else
								<a href="https://platforma.wiecejnizlek.pl/payment/select-product" class="nav-item">
									Zapisz się na kurs
								</a>
							@endif
							<a href="{{url('login')}}" class="nav-item">
								Zaloguj się
							</a>
						@endif
					</div>
				</div>
			</nav>

			@yield('content')
			<footer class="footer has-text-centered">
				<p>
					<small>
						<a class="tou-open-modal-link">
							@lang('payment.personal-data-tou-link-content')
						</a>
						&nbsp;|&nbsp;
						<a class="privacy-policy-open-modal-link">
							@lang('payment.personal-data-privacy-link-content')
						</a>
					</small>
				</p>
				<small>@lang('common.footer-copy')</small>
			</footer>
		</div>
		<div class="modals">
			<div id="tou-modal" class="modal">
				<div class="modal-background"></div>
				<div class="modal-card">
					<header class="modal-card-head">
						<p class="modal-card-title">@lang('payment.personal-data-tou-title')</p>
						<button class="delete"></button>
					</header>
					<section class="modal-card-body content">
						@include('payment.documents.tou')
					</section>
				</div>
			</div>
			<div id="privacy-policy-modal" class="modal">
				<div class="modal-background"></div>
				<div class="modal-card">
					<header class="modal-card-head">
						<p class="modal-card-title">@lang('payment.personal-data-privacy-title')</p>
						<button class="delete"></button>
					</header>
					<section class="modal-card-body content">
						@include('payment.documents.privacy-policy')
					</section>
				</div>
			</div>
		</div>
		<!-- Scripts -->
		<script src="{{ mix('js/guest.js') }}"></script>
		@yield('scripts')
	</body>
</html>

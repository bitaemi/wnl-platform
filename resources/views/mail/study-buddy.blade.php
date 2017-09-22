@extends('mail.layout')

@section('content')
	<p class="text-align: center;">
		<img src="https://media.giphy.com/media/QbkL9WuorOlgI/giphy.gif" alt="Jak dobrze, że jesteś!" style="display: block; margin: 0 auto;">
	</p>

	<h3>Cześć {{ $user->first_name or '{first_name}' }}!</h3>

	<p style="font-size: 1.25em;">Twój Study Buddy dołączył właśnie do kursu!</p>

	<p>Spieszymy z informacją, że Twój unikalny kod promocyjny został wykorzystany! Dzięki temu obdarowana przez Ciebie osoba i Ty, otrzymujecie 100zł zniżki na kurs! Dziękujemy Ci za podzielenie się informacją o Więcej niż LEK!</p>

	<p>Już wysłaliśmy zwrot na Twoje konto, w załączniku znajdziesz fakturę korygującą do Twojego zamówienia.</p>

	<p>Dziękujemy!</p>

	<p>Z pozdrowieniami,</p>
@endsection

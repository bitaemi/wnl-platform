@extends('layouts.payment')

@section('content')

<div class="row">
	<div class="col-xs-12 text-center">
		<h2>Świetny wybór!</h2>
		<div class="alert alert-success">
			Zapisujesz się na kurs stacjonarny w&nbsp;cenie <strong>2000zł</strong> brutto.
		</div>
	</div>
</div>

{!! form_start($form)  !!}

<div class="row">
	<div class="col-xs-12 text-center">
		<h2>To co, zakładamy konto?</h2>
		<p class="lead">Najpierw prosimy o&nbsp;podanie maila i&nbsp;hasła, których będziesz używać do logowania.</p>
	</div>

	<div class="col-xs-12">
		<div class="form-group">
			{!! form_row($form->email) !!}

			{!! form_row($form->password) !!}

			{!! form_row($form->password_confirmation) !!}
		</div>
	</div>
</div>

<hr>

<div class="row">
	<div class="col-xs-12 text-center">
		<h2>Adres do wysyłki materiałów</h2>
		<p class="lead">Na podany adres otrzymasz paczkę z albumem map myśli, przyborów i&nbsp;innych gadżetów. :)</p>
	</div>

	<div class="form-group">
		<div class="col-xs-12 col-sm-6">
			{!! form_row($form->first_name) !!}
		</div>
		<div class="col-xs-12 col-sm-6">
			{!! form_row($form->last_name) !!}
		</div>
		<div class="col-xs-12">
			{!! form_row($form->address) !!}
		</div>
		<div class="col-xs-12 col-sm-3">
			{!! form_row($form->zip) !!}
		</div>
		<div class="col-xs-12 col-sm-9">
			{!! form_row($form->city) !!}
		</div>
	</div>

	<div class="col-xs-12">
		<ul class="list-group">
			<li class="list-group-item">
				<div class="checkbox text-small">
					{!! form_widget($form->invoice, [ 'attr' => [ 'v-model' => 'invoice' ] ]) !!}
					{!! form_label($form->invoice) !!}
				</div>
			</li>
		</ul>
	</div>

	<div class="form-group" v-show="invoice">
		<div class="col-xs-12">
			{!! form_row($form->invoice_name) !!}
		</div>
		<div class="col-xs-12">
			{!! form_row($form->invoice_nip) !!}
		</div>
		<div class="col-xs-12">
			{!! form_row($form->invoice_address) !!}
		</div>
		<div class="col-xs-12 col-sm-3">
			{!! form_row($form->invoice_zip) !!}
		</div>
		<div class="col-xs-12 col-sm-9">
			{!! form_row($form->invoice_city) !!}
		</div>
		<div class="col-xs-12">
			{!! form_row($form->invoice_country) !!}
		</div>
	</div>
</div>

<hr>

<div class="row">
	<div class="col-xs-12 text-center">
		<h2>Wszystko zgodnie z prawem</h2>
		<p class="lead">Do legalnej realizacji zamówienia potrzebujemy Twojej zgody na przetwarzanie danych osobowych.</p>
	</div>

	<div class="col-xs-12">
		<div class="form-group small">
			<ul class="list-group">
				<li class="list-group-item">
					<div class="checkbox">
						{!! form_widget($form->consent_account) !!}
						{!! form_label($form->consent_account) !!}
					</div>
				</li>
				<li class="list-group-item">
					<div class="checkbox">
						{!! form_widget($form->consent_order) !!}
						{!! form_label($form->consent_order) !!}
					</div>
				</li>
			</ul>
		</div>
		<p>@lang('payment.personal-data-consent-newsletter-heading')</p>
		<div class="form-group small">
			<ul class="list-group">
				<li class="list-group-item">
					<div class="checkbox">
						{!! form_widget($form->consent_newsletter) !!}
						{!! form_label($form->consent_newsletter) !!}
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class="text-center">
	<button class="btn btn-primary btn-lg">Dalej</button>
</div>

{!! form_end($form, false)  !!}

@endsection
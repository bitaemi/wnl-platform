window.$ = window.jQuery = require('jquery');

$(window).on('unload', function(){});

$(function() {
	var navToggle = $('.nav-toggle'),
		navMenu = $('.nav-menu'),
		logoutLink = navMenu.find('.logout-link'),
		logoutForm = navMenu.find('#logout-form'),
		form = $('form'),
		buttons = $('.button'),
		modalsContainer = $('.modals'),
		touModal = modalsContainer.find('#tou-modal'),
		touOpenModalLinks = $('.tou-open-modal-link'),
		touCloseModalButton = touModal.find('.delete'),
		loginModalButton = $('.opens-login-modal'),
		privacyModal = modalsContainer.find('#privacy-policy-modal'),
		loginModal = modalsContainer.find('#login-modal'),
		privacyOpenModalLinks = $('.privacy-policy-open-modal-link'),
		privacyCloseModalButton = privacyModal.find('.delete'),
		loginCloseModalButton = loginModal.find('.delete'),
		expandable = $('.expandable')

	buttons.removeClass('is-disabled').removeClass('is-loading')

	navToggle.click((event) => {
		navToggle.toggleClass('is-active')
		navMenu.toggleClass('is-active')
	})

	loginModalButton.on('mousedown touchstart', function (event) {
		event.preventDefault();
		loginModal.addClass('is-active');
	})

	touOpenModalLinks.on('mousedown touchstart', function (event) {
		event.preventDefault();
		touModal.addClass('is-active');
	})

	touCloseModalButton.on('mousedown touchstart', function (event) {
		event.preventDefault();
		touModal.removeClass('is-active');
	})

	privacyOpenModalLinks.on('mousedown touchstart', function (event) {
		event.preventDefault();
		privacyModal.addClass('is-active');
	})

	privacyCloseModalButton.on('mousedown touchstart', function (event) {
		event.preventDefault();
		privacyModal.removeClass('is-active');
	})

	loginCloseModalButton.on('mousedown touchstart', function (event) {
		event.preventDefault();
		loginModal.removeClass('is-active');
	})

	form.on('submit', (event) => {
		buttons.addClass('is-disabled')
		$(event.target).find('.button:submit').removeClass('is-disabled').addClass('is-loading')
	})

	if (expandable.length > 0) {
		expandable.find('.expand').on('mousedown touchstart', function (event) {
			expandable.find('.expandable-content').slideDown()
		})
	}

	if (logoutLink.length) {
		logoutLink.click((event) => {
			logoutForm.submit()
		})
	}
})

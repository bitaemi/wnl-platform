require('./bootstrap');
import Vue from 'vue'
// import Echo from 'laravel-echo'

// Sync vue-router and vuex
import {sync} from 'vuex-router-sync'
import store from 'js/store/store'
import router from 'js/router'
sync(store, router)

// Import plugins
import VueSweetAlert from 'vue-sweetalert'
Vue.use(VueSweetAlert)

// Import and register global components
import Alert from 'js/components/global/Alert.vue'
import Avatar from 'js/components/global/Avatar.vue'
import Emoji from 'js/components/global/Emoji.vue'
import Icon from 'js/components/global/Icon.vue'
import ImageButton from 'js/components/global/ImageButton.vue'
import TextLoader from 'js/components/global/TextLoader.vue'
import VueSimpleBreakpoints from 'vue-simple-breakpoints'

Vue.use(VueSimpleBreakpoints, {
	mobile: 759, //mobile needs a top boundary, not a bottom one
	tablet: 760,
	small_desktop: 980,
	large_desktop: 1280
})

Vue.component('wnl-alert', Alert)
Vue.component('wnl-avatar', Avatar)
Vue.component('wnl-emoji', Emoji)
Vue.component('wnl-icon', Icon)
Vue.component('wnl-image-button', ImageButton)
Vue.component('wnl-text-loader', TextLoader)

// Setup a logger
import Logger from 'js/utils/logger'
$wnl.logger = new Logger()

// Set up App
$wnl.logger.debug('Starting application...')

import App from 'js/components/App.vue'
const app = new Vue({
	router,
	store,
	...App
}).$mount('#app')

// TODO: Move it to a separate component
$.ajaxSetup({
	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	url: $('body').data('base') + '/ax',
	data: {},
	method: 'POST',
	error: function (error) {
		$wnl.logger.error(error)
	}
});

// window.io = require('socket.io-client');
//
// window.Echo = new Echo({
// 	broadcaster: 'socket.io',
// 	host: window.location.hostname + ':1107'
// });

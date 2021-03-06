<template lang="html">
	<div class="scrollable-main-container">
		<div class="level wnl-screen-title">
			<div class="level-left">
				<div class="level-item big strong">
					Twoje zamówienia
				</div>
			</div>
		</div>
		<div class="level" v-if="currentUserSubscriptionActive">
			<div class="level-left">
				<div class="level-item">
					<div>
						Twój dostęp do kursu jest aktywny do:&nbsp;
					</div>
					<div class="big strong">
						{{ userFriendlySubscriptionDate }}
					</div>
				</div>
			</div>
		</div>
		<div class="notification is-success strong has-text-centered" v-if="orderSuccess">
			Dziękujemy za złożenie zamówienia!<br>Potwierdzenie znajdziesz na podanym przez siebie adresie e-mail.
		</div>
		<div v-if="loaded">
			<div v-if="hasOrders">
				<wnl-order :orderInstance="order" v-for="(order, index) in orders" :key="index"></wnl-order>
			</div>
			<div v-else>
				<div class="box has-text-centered">
					<p class="title is-5">Brak potwierdzonych zamówień <wnl-emoji name="package"></wnl-emoji></p>
					<p class="has-text-centered">
						<a :href="paymentUrl" class="button is-primary">Zapisz się na kurs</a>
					</p>
				</div>
			</div>
		</div>
		<wnl-text-loader v-else>Wczytuję zamówienia...</wnl-text-loader>
	</div>

</template>

<script>
	import axios from 'axios'
	import _ from 'lodash'
	import {getUrl, getApiUrl, getImageUrl} from 'js/utils/env'
	import {mapGetters} from 'vuex'
	import Order from './Order'
	import moment from 'moment'

	export default {
		name: 'MyOrders',
		data () {
			return {
				loaded: false,
				orders: []
			}
		},
		computed: {
			...mapGetters(['currentUserSubscriptionDates', 'currentUserSubscriptionActive']),
			paymentUrl() {
				return getUrl('payment/select-product')
			},
			hasOrders() {
				return !_.isEmpty(this.orders)
			},
			orderSuccess() {
				return this.$route.query.hasOwnProperty('payment')
			},
			userFriendlySubscriptionDate() {
				return moment(this.currentUserSubscriptionDates.max*1000).locale('pl').format('LL')
			}
		},
		methods: {
			getOrders() {
				axios.get(getApiUrl(`orders/all?include=invoices,payments`))
						.then((response) => {
							if (_.isEmpty(response.data)) {
								this.orders = []
							}

							const {included = {}, ...orders} = response.data
							const {invoices, payments} = included

							this.orders = _.reverse(Object.values(orders)
								.filter(this.isConfirmed))
								.map(order => {
									return {
										...order,
										invoices: (order.invoices || []).map(invoiceId => invoices[invoiceId]),
										payments: (order.payments || []).map(paymentId => payments[paymentId])
									}
								})

							this.loaded = true
						})
						.catch(exception => $wnl.logger.capture(exception))
			},
			isConfirmed(order) {
				return !_.isEmpty(order.method)
			},
		},
		mounted() {
			this.getOrders();
		},
		created() {
			if (this.$route.query.hasOwnProperty('payment') && this.$route.query.amount) {
				const {payment, amount, ...query} = this.$route.query;
				typeof fbq === 'function' && fbq('track', 'Purchase', {value: amount / 100, currency: 'PLN'});
				this.$router.push({
					...this.$route,
					query
				})
			}
		},
		components: {
			'wnl-order': Order,
		}
	}
</script>

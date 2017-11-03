import {set} from 'vue'
import * as types from '../mutations-types'
import uuidv1 from 'uuid/v1';


// Initial state
const state = {
    alerts: []
};

// Getters
const getters = {
	alerts: state => state.alerts,
}

// Mutations
export const mutations = {
	[types.GLOBAL_ALERTS_ADD_ALERT] (state, alert) {
		set(state, 'alerts', [...state.alerts, alert])
    },
    [types.GLOBAL_ALERTS_CLOSE_ALERT] (state, {id}) {
		const filteredList = state.alerts.filter(alert => alert.id !== id);
		set(state, 'alerts', filteredList)
	},
}

// Actions
export const actions = {
	addAlert({commit}, {text, type}) {
		commit(types.GLOBAL_ALERTS_ADD_ALERT, {text, type, id: uuidv1()})
	},
	closeAlert({commit, state}, payload) {
		commit(types.GLOBAL_ALERTS_CLOSE_ALERT, payload)
	}
};

export default {
	state,
	getters,
	mutations,
	actions
}

import axios from 'axios';
import {getApiUrl} from 'js/utils/env';

let currentUser;

export function getCurrentUser() {
	if (currentUser) {
		return Promise.resolve(currentUser);
	} else {
		const promisedUser = axios.get(getApiUrl('users/current/profile'));

		return promisedUser.then((result) => {
			currentUser = result;

			return result;
		});
	}
}


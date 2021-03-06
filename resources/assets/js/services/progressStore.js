import axios from 'axios';
import {getApiUrl} from 'js/utils/env';
import {getCurrentUser} from './user';

// TODO: Mar 9, 2017 - Use config when it's ready
export const STATUS_IN_PROGRESS = 'in-progress';
export const STATUS_COMPLETE = 'complete';

const CACHE_VERSION = 1;

const setCourseProgress = ({courseId, lessonId, ...props}, value) => {
	getCurrentUser().then(({id}) => {
		axios.put(getApiUrl(`users/${id}/state/course/${courseId}`), value);
	})
};

const setLessonProgress = ({courseId, lessonId}, value) => {
	getCurrentUser().then(({id}) => {
		axios.put(getApiUrl(`users/${id}/state/course/${courseId}/lesson/${lessonId}`), {
			lesson: value
		});
	})
};

const completeSection = (lessonState, payload) => {
	const {screenId, sectionId} = payload
	const stateWithScreen = _getScreenProgress(lessonState, payload)
	const stateWithSections = _getSectionProgress(stateWithScreen, payload)

	setLessonProgress(payload, stateWithSections)

	return stateWithSections;
};

const completeSubsection = (lessonState, payload) => {
	const {sectionId, screenId, subsectionId, route} = payload;
	const stateWithScreen = _getScreenProgress(lessonState, payload)
	const stateWithSections = _getSectionProgress(stateWithScreen, payload)

	if (!stateWithSections.screens[screenId].sections[sectionId].subsections) {
		stateWithSections.screens[screenId].sections[sectionId].subsections = {
			[subsectionId]: {
				status: STATUS_COMPLETE
			}
		}
	} else {
		stateWithSections.screens[screenId].sections[sectionId].subsections = {
			...stateWithSections.screens[screenId].sections[sectionId].subsections,
			[subsectionId]: {
				status: STATUS_COMPLETE
			}
		}
	}

	setLessonProgress(payload, stateWithSections)

	return stateWithSections;
};

const completeScreen = (lessonState, {screenId, route, ...payload}) => {
	const updatedState = {...lessonState};

	updatedState.route = route;

	updatedState.screens = lessonState.screens || {};
	updatedState.screens[screenId] = updatedState.screens[screenId] || {};
	updatedState.screens[screenId].status = STATUS_COMPLETE;


	setLessonProgress(payload, updatedState)

	return updatedState;
};

const completeLesson = (courseState, payload) => {
	const lessonState = courseState.lessons[payload.lessonId];
	const updatedLessonState = {
		...lessonState,
		status: STATUS_COMPLETE,
		route: payload.route
	};
	const updatedCourseState = {
		...courseState,
		lessons: {
			...courseState.lessons,
			[payload.lessonId]: {
				status: STATUS_COMPLETE
			}
		}
	}


	setLessonProgress(payload, updatedLessonState)
	setCourseProgress(payload, updatedCourseState)

	return updatedLessonState
};

const startLesson = (courseState, payload) => {
	const lessonState = courseState.lessons[payload.lessonId];
	const updatedLessonState = {
		...lessonState,
		status: STATUS_IN_PROGRESS,
		route: payload.route
	};
	const updatedCourseState = {
		...courseState,
		lessons: {
			...courseState.lessons,
			[payload.lessonId]: {
				status: STATUS_IN_PROGRESS
			}
		}
	}


	setLessonProgress(payload, updatedLessonState)
	setCourseProgress(payload, updatedCourseState)

	return updatedLessonState
};

const getCourseProgress = ({courseId}) => {
	return new Promise((resolve) => {
		getCurrentUser()
			.then(({id}) => {
				return axios.get(getApiUrl(`users/${id}/state/course/${courseId}`));
			})
			.then(({data: {lessons} = {}}) => {
				return resolve({
					lessons
				})
			});
	});
};

const getLessonProgress = ({courseId, lessonId}) => {
	return new Promise((resolve) => {
		getCurrentUser()
			.then(({id}) => {
				return axios.get(getApiUrl(`users/${id}/state/course/${courseId}/lesson/${lessonId}`));
			})
			.then(({data: {lesson}} = {}) => {
				return resolve(lesson)
			});
	});
};

const _getScreenProgress = (lessonState = {}, {route, screenId}) => {
	const updatedState = {
		screens: {},
		...lessonState,
		route,
	}

	if (!updatedState.screens[screenId]) {
		updatedState.screens[screenId] = {
			status: STATUS_IN_PROGRESS
		}
	}

	return updatedState;
}

const _getSectionProgress = (lessonState = {}, {route, screenId, sectionId}) => {
	const updatedState = {...lessonState};

	if (!updatedState.screens[screenId].sections) {
		updatedState.screens[screenId].sections = {
			[sectionId]: {
				status: STATUS_COMPLETE
			}
		}
	} else {
		updatedState.screens[screenId].sections = {
			...updatedState.screens[screenId].sections,
			[sectionId]: {
				...updatedState.screens[screenId].sections[sectionId],
				status: STATUS_COMPLETE
			}
		}
	}

	return updatedState
}

export default {
	getCourseProgress,
	getLessonProgress,
	completeSection,
	completeScreen,
	completeLesson,
	completeSubsection,
	startLesson
};

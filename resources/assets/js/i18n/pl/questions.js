export const questions = {
	dashboard: {
		notifications: {
			close: 'Zamknij',
			heading: 'Ostatnie dyskusje',
			toggle: 'Powiadomienia',
		},
		plan: {
			create: {
				cta: 'Zaplanuj pracę',
				heading: 'Zaplanuj pracę z pytaniami!',
				tip: 'Plan pracy pomoże Ci określić tempo, którym spokojnie rozwiążesz wszystkie pytania!',
			},
			heading: 'Plan pracy',
		},
		stats: {
			error: 'Ups... Niestety, nie udało nam się załadować Twoich statystyk... Spróbujesz jeszcze raz? Jeśli problem będzie się powtarzał, daj nam znać w zakładce Pomoc > Pomoc techniczna. Przepraszamy!',
			heading: 'Twoje statystyki',
			scores: 'Rozwiązane pytania i wyniki',
		},
	},
	filters: {
		activeFiltersReview: 'Aktywne filtry: {filters}',
		activeHeading: 'Aktywne filtry',
		allQuestions: 'Wszystkie pytania',
		autorefresh: 'Odświeżaj automatycznie',
		filteringResult: 'Pasujące pytania:',
		filteringResultFrom: 'z {totalCount} w bazie',
		items: {
			'correct': 'Rozwiązane poprawnie',
			'exams': 'Egzaminy',
			'incorrect': 'Rozwiązane błędnie',
			'subjects': 'Przedmioty i tematy',
			'planned': 'Zaplanowane na dziś',
			'resolution': 'Status',
			'unresolved': 'Nierozwiązane',
		},
		heading: 'Wybierz filtry',
		hide: 'Schowaj filtry',
		refresh: 'Odśwież',
		show: 'Pokaż filtry',
		submit: 'Wybierz pasujące pytania',
	},
	nav: {
		dashboard: 'Dashboard',
		planner: 'Zaplanuj pracę',
		solving: 'Rozwiązuj pytania',
		stats: 'Sprawdź statystyki',
	},
	question: {
		edit: 'Edytuj pytanie',
		tags: 'Tagi',
	},
	plan: {
		change: 'Zmieniam plan',
		dontChange: 'Nie zmieniam planu',
		headings: {
			change: 'Zmień plan',
			create: 'Stwórz nowy plan',
			dates: '1. Ile masz czasu?',
			endDate: 'Koniec',
			questions: '3. Ile pytań chcesz rozwiązać?',
			slackDays: '2. Ile dni wolnych planujesz?',
			startDate: 'Start',
			summary: '4. Podsumowanie planu',
		},
		options: {
			all: 'Wszystkie pytania',
			custom: 'Własny zakres',
			unresolvedAndIncorrect: 'Nierozwiązane + rozwiązane błędnie',
			count: 'Pytań: {count}',
		},
		progress: {
			average: {
				congrats: ' - gratulacje!',
				greater: ' i jest większa lub równa planowanej ',
				is: 'Twoja dzienna średnia wynosi ',
				less: ' i jest mniejsza, niż planowana ',
			},
			currentPlan: 'Obecny plan',
			day: 'Dzień {day}',
			explain: 'Rozwiązane pytania',
			heading: 'Jak Ci idzie?',
		},
		solvePlanned: 'Rozwiązuj zaplanowane na dzisiaj',
		start: {
			heading: 'Zaczynasz {date}',
			tip: 'Obecny plan zakłada zrobienie {count} pytań w {days} dni, co daje średnio {average} pytań na dzień.',
		},
		submit: 'Akceptuję plan!',
		summaryAverage: 'pytań na dzień',
		summaryCount: 'pytań w',
		summaryDays: 'dni, daje średnio',
		summaryTip: 'poniżej 100: plan spokojny, 100 - 200: plan intensywny, powyżej 200: plan hardkor',
		tips: {
			endDate: 'Kliknij, aby zmienić końcową datę',
			slackDays: 'Wpisz ilość dni, w których nie planujesz przerabiać pytań',
			startDate: 'Kliknij, aby zmienić początkową datę',
		}
	},
	solving: {
		abort: 'Przerwij',
		activeQuestionTip: 'Kliknij ponownie na wybraną odpowiedź, aby potwierdzić ją i sprawdzić wynik. Następnie, możesz kliknąć dwa razy w dowolną odpowiedź, aby przejść do następnego pytania.',
		confirm: {
			no: 'Nie, przerywam',
			title: 'Może jednak chcesz dokończyć test?',
			unanswered: 'Pytań bez odpowiedzi: {count}',
			yes: 'Tak, chcę dokończyć!',
		},
		current: 'Pytanie {number} z ',
		hideAnswers: 'Ukryj rozwiązania',
		new: 'Nowy test',
		resolve: 'Sprawdź wyniki',
		results: {
			correct: 'Rozwiązane poprawnie',
			displayOnly: 'Wyświetl tylko:',
			incorrect: 'Rozwiązane błędnie',
			unanswered: 'Nierozwiązane',
		},
		score: 'Wynik:',
		setAsCurrent: 'Ustaw jako aktualne',
		showAnswers: 'Pokaż rozwiązania',
		tabs: {
			current: 'Aktualne pytanie ({current})',
			list: 'Lista pytań ({count})',
			test: 'Sprawdź się!',
		},
		test: {
			headers: {
				answered: 'Rozwiązanych: {answered}/{total}',
				count: 'Na ile pytań chcesz odpowiedzieć?',
				remaining: 'Pozostało:',
				time: 'Ile czasu chcesz poświęcić?',
			},
			start: 'Rozpocznij test!',
			title: 'Rozwiąż zestaw ułożony na podstawie aktywnych filtrów...',
		},
		unanswered: {
			all: 'Pokaż wszystkie pytania',
			filter: 'Pokaż tylko nierozwiązane',
		},
		withNumber: 'Pytanie {number}',
	},
	zeroState: 'Oho, nie mamy pasujących pytań... Spróbujesz wyłączyć niektóre z filtrów?',
}
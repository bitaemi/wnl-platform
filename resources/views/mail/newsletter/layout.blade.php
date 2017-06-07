<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		/* BETHINK MAIL STYLEGUIDE */
		html, body {
			color: #242d47;
			font-family: sans-serif;
			font-size: 14px;
			line-height: 1.7em;
		}

		h1 {
			font-size: 2rem;
		}
		h2 {
			font-size: 1.75rem;
		}
		h3 {
			font-size: 1.5rem;
		}
		h4 {
			font-size: 1.25rem;
		}

		a.button,
		a.button:visited,
		a.button:active {
			border: 1px solid #3f9fa7;
			border-radius: 100px;
			color: #3f9fa7;
			display: inline-block;
			font-size: 0.8em;
			font-weight: bold;
			padding: 5px 15px;
			text-transform: uppercase;
		}

		a.button:hover {
			border-color: #81d8e0;
			color: #81d8e0;
		}

		a,
		a:visited,
		a:active {
			color: #3f9fa7;
			text-decoration: none;
		}

		a:hover {
			color: #81d8e0;
			text-decoration: none;
		}

		.has-text-centered {
			text-align: center;
		}
		.has-text-left {
			text-align: left;
		}
		.has-text-right {
			text-align: right;
		}

		.is-centered {
			margin-left: auto;
			margin-right: auto;
		}

		.gmail-sucks {
			background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48c3ZnIHdpZHRoPSIyMjBweCIgaGVpZ2h0PSIzN3B4IiB2aWV3Qm94PSIwIDAgMjIwIDM3IiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPiAgICAgICAgPHRpdGxlPmxvZ28vbWFpbi9ub3JtYWw8L3RpdGxlPiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4gICAgPGRlZnM+PC9kZWZzPiAgICA8ZyBpZD0iZWxlbWVudHMiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPiAgICAgICAgPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTUxLjAwMDAwMCwgLTQ5LjAwMDAwMCkiIGlkPSJsb2dvL21haW4vbm9ybWFsIiBmaWxsPSIjMjQyRDQ3Ij4gICAgICAgICAgICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSg1MS4wMDAwMDAsIDQ5LjAwMDAwMCkiPiAgICAgICAgICAgICAgICA8ZyBpZD0ibG9nbyI+ICAgICAgICAgICAgICAgICAgICA8ZyBpZD0id2llY2Vqbml6bGVrX2xvZ29fcG96aW9tLTAxIj4gICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNODEuODIyNzM3OSwxNC42OTA4NSBDODEuNzY4NzQ3OSwxNC42ODcxNSA4MS42NTc0NjI0LDE0LjczMzQgODEuNTUwMjE3LDE0LjcyNTYzIEM4MS4yMjgxMTM1LDE0LjcwMTk1IDgwLjk3MTAxODQsMTQuNTE5OTEgODAuODMzMjg4OCwxNC4xODM1OCBDNzkuMzg3Njc5NSwxMC4yNzA4MyA3NS44OTY2OTQ1LDcuMDI0ODIgNzEuNDE0MDU2OCw1LjU1NDgxIEM3MC45OTI0MjA3LDUuNDE1MzIgNzAuNzU0NzkxMyw0Ljk2MjgxIDcwLjg5MzYyMjcsNC41Mzc2OCBDNzEuMDMyMDg2OCw0LjExMjkyIDcxLjQ4MTI2ODgsMy44NzM5IDcxLjkwMjkwNDgsNC4wMTMzOSBDNzYuODAzODczMSw1LjY3NjkxIDgwLjcwMTA2ODQsOS4yNzkyMyA4Mi4yNzYzMjcyLDEzLjYzNjM1IEM4Mi40MDYzNDM5LDE0LjA4MTA5IDgyLjIxNDI1NzEsMTQuNTAyMTUgODEuODIyNzM3OSwxNC42OTA4NSBMODEuODIyNzM3OSwxNC42OTA4NSBaIE0yMS40MDUwMDgzLDMzLjgyMjA3IEwyMS4xMzU3OTMsMzMuODIyMDcgQzExLjE3NDgyNDcsMzMuODIyMDcgMy4wNDQ3NDEyNCwyNi45ODc0MyAzLjA0NDc0MTI0LDE4LjUyNTkgQzMuMDQ0NzQxMjQsMTAuMTE4MzkgMTEuMTIxMjAyLDMuMjI5NzMgMjEuMTM1NzkzLDMuMjI5NzMgTDIxLjI0MzQwNTcsMy4yMjk3MyBMMjEuMzUxMDE4NCwzLjIyOTczIEw0Mi41NzA5MTgyLDMuMjI5NzMgTDQyLjUyNjExMDIsMzMuODIyMDcgTDIxLjQwNTAwODMsMzMuODIyMDcgTDIxLjQwNTAwODMsMzMuODIyMDcgWiBNNjYuNjM3MjI4NywwLjI0NjQyIEw2NS45OTExODUzLDAuMjQ2NDIgTDY1LjY2ODM0NzIsMC4yNDY0MiBMMjEuMjk3Mzk1NywwLjI0NjQyIEwyMS4xODk3ODMsMC4yNDY0MiBMMjEuMDgxODAzLDAuMjQ2NDIgQzkuNDUxOTE5ODcsMC4yNDY0MiAwLjAyOTc0OTU4MjYsOC40MzcxMSAwLjAyOTc0OTU4MjYsMTguNTI1OSBDMC4wMjk3NDk1ODI2LDI4LjYxNDY5IDkuNTA1OTA5ODUsMzYuODA1MzggMjEuMDgxODAzLDM2LjgwNTM4IEw2NS42MTQzNTczLDM2LjgwNTM4IEw2NS45MzcxOTUzLDM2LjgwNTM4IEw2Ni41ODMyMzg3LDM2LjgwNTM4IEM3Ny4zNDkyODIxLDM2LjgwNTM4IDg2LjEyMzIwNTMsMjguNTcyODggODYuMTIzMjA1MywxOC40OTg4OSBDODYuMTIzMjA1Myw4LjQyNDkgNzcuNDAyOTA0OCwwLjI0NjQyIDY2LjYzNzIyODcsMC4yNDY0MiBMNjYuNjM3MjI4NywwLjI0NjQyIFoiIGlkPSJGaWxsLTEiPjwvcGF0aD4gICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMzUuNDMzMjIyLDIwLjM3MjIgQzM0LjY3OTU2NTksMjAuMzcyMiAzNC4wODcxNDUyLDE5Ljc3NTM5IDM0LjA4NzE0NTIsMTkuMDE2MTUgQzM0LjA4NzE0NTIsMTguMjU2OTEgMzQuNjc5NTY1OSwxNy42NjAxIDM1LjQzMzIyMiwxNy42NjAxIEMzNi4xODcyNDU0LDE3LjY2MDEgMzYuNzc5Mjk4OCwxOC4yNTY5MSAzNi43NzkyOTg4LDE5LjAxNjE1IEMzNi43NzkyOTg4LDE5Ljc3NTM5IDM2LjE4NzI0NTQsMjAuMzcyMiAzNS40MzMyMjIsMjAuMzcyMiBMMzUuNDMzMjIyLDIwLjM3MjIgWiBNMjAuNjI2NzQ0Niw5LjA4OTc5IEMyMC4xNDE5MzY2LDkuMDg5NzkgMTkuNzExNDg1OCw4LjY1NjE1IDE5LjcxMTQ4NTgsOC4xNjc3NSBDMTkuNzExNDg1OCw3LjY3OTcyIDIwLjE0MTkzNjYsNy4yNDU3MSAyMC42MjY3NDQ2LDcuMjQ1NzEgQzIxLjExMTE4NTMsNy4yNDU3MSAyMS41NDIwMDMzLDcuNjc5NzIgMjEuNTQyMDAzMyw4LjE2Nzc1IEMyMS41NDIwMDMzLDguNjU2MTUgMjEuMTExMTg1Myw5LjA4OTc5IDIwLjYyNjc0NDYsOS4wODk3OSBMMjAuNjI2NzQ0Niw5LjA4OTc5IFogTTM1LjQzMzIyMiwxNi4wMzI4NCBDMzQuNjUwMTgzNiwxNi4wMzI4NCAzMy45MzE3ODYzLDE2LjM1MzYzIDMzLjM5ODEzMDIsMTYuODY3NTYgTDIyLjQ4NTE3NTMsOC44MjQxMyBDMjIuNTY3NDQ1Nyw4LjYwMzk4IDIyLjYxODg2NDgsOC4zNjcxOCAyMi42MTg4NjQ4LDguMTEzNzMgQzIyLjYxODg2NDgsNi45NzQ1IDIxLjcwMzYwNiw2LjEwNjg1IDIwLjYyNjc0NDYsNi4xMDY4NSBDMTkuNDk1ODkzMiw2LjEwNjg1IDE4LjYzNDYyNDQsNy4wMjg4OSAxOC42MzQ2MjQ0LDguMTEzNzMgQzE4LjYzNDYyNDQsOS4yNTI1OSAxOS41NDk4ODMxLDEwLjEyMDYxIDIwLjYyNjc0NDYsMTAuMTIwNjEgQzIxLjA4MTQzNTcsMTAuMTIwNjEgMjEuNTAxOTY5OSw5Ljk1ODkyIDIxLjg0MjQzNzQsOS42OTQzNyBMMzIuNzY0OTQxNiwxNy43NDUyIEMzMi41Nzk0NjU4LDE4LjEzMjU5IDMyLjQ3MjIyMDQsMTguNTYyOSAzMi40NzIyMjA0LDE5LjAxNjE1IEMzMi40NzIyMjA0LDE5LjQ0ODY4IDMyLjU2OTU0OTIsMTkuODYwODYgMzIuNzM5NTk5MywyMC4yMzQ1NiBMMjEuODY2MzEwNSwyNy44NjkxNCBDMjEuNTIyMTcwMywyNy41OTI3NSAyMS4wOTI0NTQxLDI3LjQyMzY2IDIwLjYyNjc0NDYsMjcuNDIzNjYgQzE5LjQ5NTg5MzIsMjcuNDIzNjYgMTguNjM0NjI0NCwyOC4zNDU3IDE4LjYzNDYyNDQsMjkuNDMwNTQgQzE4LjYzNDYyNDQsMzAuNTY5NCAxOS41NDk4ODMxLDMxLjQzNzQyIDIwLjYyNjc0NDYsMzEuNDM3NDIgQzIxLjcwMzYwNiwzMS40Mzc0MiAyMi42MTg4NjQ4LDMwLjUxNTM4IDIyLjYxODg2NDgsMjkuNDMwNTQgQzIyLjYxODg2NDgsMjkuMTg4MTkgMjIuNTcwMDE2NywyOC45NjIxMiAyMi40OTQzNTczLDI4Ljc1MDQ4IEwzMy4zNTQ3OTEzLDIxLjEyNDc4IEMzMy44OTI0ODc1LDIxLjY2MzEzIDM0LjYyOTI0ODcsMjEuOTk5NDYgMzUuNDMzMjIyLDIxLjk5OTQ2IEMzNy4xMDI1MDQyLDIxLjk5OTQ2IDM4LjM5NDU5MSwyMC42NDM0MSAzOC4zOTQ1OTEsMTkuMDE2MTUgQzM4LjM5NDU5MSwxNy4zODg4OSAzNy4wNDg1MTQyLDE2LjAzMjg0IDM1LjQzMzIyMiwxNi4wMzI4NCBMMzUuNDMzMjIyLDE2LjAzMjg0IFoiIGlkPSJGaWxsLTIiPjwvcGF0aD4gICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTIuMjgxMDY4NCwyNS41NzkyMSBDMTEuOTgzNTcyNiwyNS41NzkyMSAxMS43NDI2Mzc3LDI1LjgyMjMgMTEuNzQyNjM3NywyNi4xMjE2MyBDMTEuNzQyNjM3NywyNi40MjEzMyAxMS45ODM1NzI2LDI2LjY2NDA1IDEyLjI4MTA2ODQsMjYuNjY0MDUgQzEyLjU3ODU2NDMsMjYuNjY0MDUgMTIuODE5NDk5MiwyNi40MjEzMyAxMi44MTk0OTkyLDI2LjEyMTYzIEMxMi44MTk0OTkyLDI1LjgyMjMgMTIuNTc4NTY0MywyNS41NzkyMSAxMi4yODEwNjg0LDI1LjU3OTIxIiBpZD0iRmlsbC0zIj48L3BhdGg+ICAgICAgICAgICAgICAgICAgICAgICAgPHBhdGggZD0iTTkuODU4MTMwMjIsMjIuNjUwMjkgQzkuMzUyNzU0NTksMjIuNjUwMjkgOC45NDI4NzE0NSwyMy4wNjMyMSA4Ljk0Mjg3MTQ1LDIzLjU3MjMzIEM4Ljk0Mjg3MTQ1LDI0LjA4MTgyIDkuMzUyNzU0NTksMjQuNDk0MzcgOS44NTgxMzAyMiwyNC40OTQzNyBDMTAuMzYzODczMSwyNC40OTQzNyAxMC43NzMzODksMjQuMDgxODIgMTAuNzczMzg5LDIzLjU3MjMzIEMxMC43NzMzODksMjMuMDYzMjEgMTAuMzYzODczMSwyMi42NTAyOSA5Ljg1ODEzMDIyLDIyLjY1MDI5IiBpZD0iRmlsbC00Ij48L3BhdGg+ICAgICAgICAgICAgICAgICAgICAgICAgPHBhdGggZD0iTTguNzI3NjQ2MDgsMTcuMDA5MjcgQzcuNzU4Mzk3MzMsMTcuMDA5MjcgNy4wMDQzNzM5NiwxNy43Njg1MSA3LjAwNDM3Mzk2LDE4Ljc0NDk0IEM3LjAwNDM3Mzk2LDE5LjcyMTM3IDcuNzU4Mzk3MzMsMjAuNDgwNjEgOC43Mjc2NDYwOCwyMC40ODA2MSBDOS42OTY1Mjc1NSwyMC40ODA2MSAxMC40NTA1NTA5LDE5LjcyMTM3IDEwLjQ1MDU1MDksMTguNzQ0OTQgQzEwLjQ1MDU1MDksMTcuNzY4NTEgOS42OTY1Mjc1NSwxNy4wMDkyNyA4LjcyNzY0NjA4LDE3LjAwOTI3IiBpZD0iRmlsbC01Ij48L3BhdGg+ICAgICAgICAgICAgICAgICAgICAgICAgPHBhdGggZD0iTTExMC43ODc4MTMsMTMuNjY3NDMgQzExMC43ODc4MTMsMTMuNTg3ODggMTEwLjg2Njc3OCwxMy41MDgzMyAxMTAuOTQ2MTEsMTMuNTA4MzMgQzExMS4wMjUwNzUsMTMuNDI4NDEgMTExLjEwNDA0LDEzLjQyODQxIDExMS4yNjIzMzcsMTMuNDI4NDEgTDExMS42NTc1MjksMTMuNDI4NDEgQzExMS43MzY0OTQsMTMuNDI4NDEgMTExLjgxNTQ1OSwxMy40Mjg0MSAxMTEuODk0NzkxLDEzLjUwODMzIEMxMTEuOTczNzU2LDEzLjU4Nzg4IDExMS45NzM3NTYsMTMuNjY3NDMgMTExLjk3Mzc1NiwxMy43NDY5OCBMMTExLjk3Mzc1NiwxMy45ODYgTDEwOS4yODU2NDMsMjIuOTA2MzMgQzEwOS4yMDY2NzgsMjMuMDY1OCAxMDkuMTI3NzEzLDIzLjIyNDkgMTA5LjA0ODM4MSwyMy4zMDQ4MiBDMTA4Ljk2OTQxNiwyMy4zODQzNyAxMDguODExNDg2LDIzLjM4NDM3IDEwOC42NTMxODksMjMuMzg0MzcgTDEwOC4zMzY5NjIsMjMuMzg0MzcgQzEwOC4wMjA3MzUsMjMuMzg0MzcgMTA3Ljc4MzQ3MiwyMy4yMjQ5IDEwNy43MDQ1MDgsMjIuOTA2MzMgTDEwNS4zMzI2MjEsMTUuMzQwMiBMMTAyLjk2MDczNSwyMi45MDYzMyBDMTAyLjg4MTc3LDIzLjIyNDkgMTAyLjY0NDUwOCwyMy4zODQzNyAxMDIuMzI4MjgsMjMuMzg0MzcgTDEwMi4wMTIwNTMsMjMuMzg0MzcgQzEwMS44NTQxMjQsMjMuMzg0MzcgMTAxLjY5NTgyNiwyMy4zODQzNyAxMDEuNjE2ODYxLDIzLjMwNDgyIEMxMDEuNTM3ODk2LDIzLjIyNDkgMTAxLjQ1ODU2NCwyMy4xNDUzNSAxMDEuMzc5NTk5LDIyLjkwNjMzIEw5OC42OTE0ODU4LDEzLjk4NiBMOTguNjkxNDg1OCwxMy43NDY5OCBDOTguNjkxNDg1OCwxMy42Njc0MyA5OC42OTE0ODU4LDEzLjU4Nzg4IDk4Ljc3MDQ1MDgsMTMuNTA4MzMgQzk4Ljg0OTc4MywxMy40Mjg0MSA5OC45Mjg3NDc5LDEzLjQyODQxIDk5LjAwNzcxMjksMTMuNDI4NDEgTDk5LjQwMzI3MjEsMTMuNDI4NDEgQzk5LjQ4MjIzNzEsMTMuNDI4NDEgOTkuNjQwMTY2OSwxMy40Mjg0MSA5OS43MTk0OTkyLDEzLjUwODMzIEM5OS43OTg0NjQxLDEzLjU4Nzg4IDk5Ljg3NzQyOSwxMy42Njc0MyA5OS44Nzc0MjksMTMuNjY3NDMgTDEwMi4yNDkzMTYsMjEuNjMyMDUgTDEwNC43NzkxMzIsMTMuNzQ2OTggQzEwNC43NzkxMzIsMTMuNjY3NDMgMTA0Ljg1ODA5NywxMy41ODc4OCAxMDQuOTM3NDI5LDEzLjUwODMzIEMxMDUuMDE2Mzk0LDEzLjQyODQxIDEwNS4xNzQ2OTEsMTMuNDI4NDEgMTA1LjI1MzY1NiwxMy40Mjg0MSBMMTA1LjY0ODg0OCwxMy40Mjg0MSBDMTA1LjgwNzE0NSwxMy40Mjg0MSAxMDUuODg2MTEsMTMuNDI4NDEgMTA1Ljk2NTA3NSwxMy41MDgzMyBDMTA2LjA0NDA0LDEzLjU4Nzg4IDEwNi4xMjMzNzIsMTMuNjY3NDMgMTA2LjEyMzM3MiwxMy43NDY5OCBMMTA4LjY1MzE4OSwyMS42MzIwNSBMMTEwLjc4NzgxMywxMy42Njc0MyIgaWQ9IkZpbGwtNiI+PC9wYXRoPiAgICAgICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0xMTUuMjk0MzI0LDIzLjIyNDkgQzExNS4yMTUzNTksMjMuMzA0ODIgMTE1LjEzNjAyNywyMy4zMDQ4MiAxMTQuOTc4MDk3LDIzLjMwNDgyIEwxMTQuNjYxODcsMjMuMzA0ODIgQzExNC41MDM1NzMsMjMuMzA0ODIgMTE0LjQyNDYwOCwyMy4zMDQ4MiAxMTQuMzQ1NjQzLDIzLjIyNDkgQzExNC4yNjYzMTEsMjMuMTQ1MzUgMTE0LjI2NjMxMSwyMy4wNjU4IDExNC4yNjYzMTEsMjIuOTA2MzMgTDExNC4yNjYzMTEsMTMuNzQ2OTggQzExNC4yNjYzMTEsMTMuNTg3ODggMTE0LjI2NjMxMSwxMy41MDgzMyAxMTQuMzQ1NjQzLDEzLjQyODQxIEMxMTQuNDI0NjA4LDEzLjM0ODg2IDExNC41MDM1NzMsMTMuMzQ4ODYgMTE0LjY2MTg3LDEzLjM0ODg2IEwxMTQuOTc4MDk3LDEzLjM0ODg2IEMxMTUuMTM2MDI3LDEzLjM0ODg2IDExNS4yMTUzNTksMTMuMzQ4ODYgMTE1LjI5NDMyNCwxMy40Mjg0MSBDMTE1LjM3MzI4OSwxMy41MDgzMyAxMTUuMzczMjg5LDEzLjU4Nzg4IDExNS4zNzMyODksMTMuNzQ2OTggTDExNS4zNzMyODksMjIuOTA2MzMgQzExNS40NTIyNTQsMjMuMDY1OCAxMTUuMzczMjg5LDIzLjE0NTM1IDExNS4yOTQzMjQsMjMuMjI0OSBMMTE1LjI5NDMyNCwyMy4yMjQ5IFogTTExNS41MzE1ODYsMTEuMTk4NDIgQzExNS40NTIyNTQsMTEuMjc3OTcgMTE1LjM3MzI4OSwxMS4yNzc5NyAxMTUuMjE1MzU5LDExLjI3Nzk3IEwxMTQuNTAzNTczLDExLjI3Nzk3IEMxMTQuMzQ1NjQzLDExLjI3Nzk3IDExNC4yNjYzMTEsMTEuMjc3OTcgMTE0LjE4NzM0NiwxMS4xOTg0MiBDMTE0LjEwODM4MSwxMS4xMTg4NyAxMTQuMTA4MzgxLDExLjAzOTMyIDExNC4xMDgzODEsMTAuODc5ODUgTDExNC4xMDgzODEsMTAuMTYzMTYgQzExNC4xMDgzODEsMTAuMDAzNjkgMTE0LjEwODM4MSw5LjkyNDE0IDExNC4xODczNDYsOS44NDQ1OSBDMTE0LjI2NjMxMSw5Ljc2NDY3IDExNC4zNDU2NDMsOS42ODUxMiAxMTQuNTAzNTczLDkuNjg1MTIgTDExNS4yMTUzNTksOS42ODUxMiBDMTE1LjM3MzI4OSw5LjY4NTEyIDExNS40NTIyNTQsOS43NjQ2NyAxMTUuNTMxNTg2LDkuODQ0NTkgQzExNS42MTA1NTEsOS45MjQxNCAxMTUuNjg5NTE2LDEwLjAwMzY5IDExNS42ODk1MTYsMTAuMTYzMTYgTDExNS42ODk1MTYsMTAuODc5ODUgQzExNS42MTA1NTEsMTEuMDM5MzIgMTE1LjYxMDU1MSwxMS4xMTg4NyAxMTUuNTMxNTg2LDExLjE5ODQyIEwxMTUuNTMxNTg2LDExLjE5ODQyIFoiIGlkPSJGaWxsLTciPjwvcGF0aD4gICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTI1LjI1NjAyNywxNy43MjkyOSBMMTI1LjI1NjAyNywxNy43MjkyOSBDMTI1LjI1NjAyNywxNi42OTQwMyAxMjQuOTM5OCwxNS44MTc4NyAxMjQuNDY1Mjc1LDE1LjE4MDczIEMxMjMuOTExNzg2LDE0LjU0MzU5IDEyMy4yMDAzNjcsMTQuMjI1MDIgMTIyLjI1MTY4NiwxNC4yMjUwMiBDMTIxLjMwMzAwNSwxNC4yMjUwMiAxMjAuNTkxMjE5LDE0LjU0MzU5IDEyMC4wMzc3MywxNS4xODA3MyBDMTE5LjQ4NDYwOCwxNS44MTc4NyAxMTkuMjQ3MzQ2LDE2LjYxNDQ4IDExOS4yNDczNDYsMTcuNjQ5NzQgTDExOS4yNDczNDYsMTcuNzI5MjkgTDEyNS4yNTYwMjcsMTcuNzI5MjkgTDEyNS4yNTYwMjcsMTcuNzI5MjkgWiBNMTI1LjMzNDk5MiwxNC40NjQwNCBDMTI2LjA0NjQxMSwxNS4zNDAyIDEyNi40NDE5NywxNi41MzQ5MyAxMjYuNDQxOTcsMTguMTI3NzggTDEyNi40NDE5NywxOC40NDYzNSBDMTI2LjQ0MTk3LDE4LjYwNTQ1IDEyNi4zNjI2MzgsMTguNjg1IDEyNi4yODM2NzMsMTguNzY0OTIgQzEyNi4yMDQ3MDgsMTguODQ0NDcgMTI2LjEyNTc0MywxOC44NDQ0NyAxMjUuOTY3NDQ2LDE4Ljg0NDQ3IEwxMTkuMTY4MzgxLDE4Ljg0NDQ3IEwxMTkuMTY4MzgxLDE5LjAwMzk0IEMxMTkuMTY4MzgxLDE5LjY0MTA4IDExOS4zMjYzMTEsMjAuMTk4NjcgMTE5LjU2MzU3MywyMC42NzYzNCBDMTE5LjgwMDgzNSwyMS4yMzM5MyAxMjAuMTk2MDI3LDIxLjYzMjA1IDEyMC41OTEyMTksMjEuOTUwNjIgQzEyMS4wNjU3NDMsMjIuMjY5MTkgMTIxLjUzOTksMjIuNDI4NjYgMTIyLjE3MjcyMSwyMi40Mjg2NiBDMTIyLjg4NDE0LDIyLjQyODY2IDEyMy40Mzc2MjksMjIuMjY5MTkgMTIzLjkxMTc4NiwyMi4wMzAxNyBDMTI0LjM4NjMxMSwyMS43OTE1MiAxMjQuNzAyNTM4LDIxLjQ3Mjk1IDEyNC44NjA0NjcsMjEuMjMzOTMgQzEyNC45Mzk4LDIxLjA3NDQ2IDEyNS4wOTc3MywyMC45OTQ5MSAxMjUuMDk3NzMsMjAuOTE1MzYgQzEyNS4xNzY2OTQsMjAuOTE1MzYgMTI1LjI1NjAyNywyMC44MzU4MSAxMjUuNDEzOTU3LDIwLjgzNTgxIEwxMjUuNzMwMTg0LDIwLjgzNTgxIEMxMjUuODA5MTQ5LDIwLjgzNTgxIDEyNS45Njc0NDYsMjAuODM1ODEgMTI2LjA0NjQxMSwyMC45MTUzNiBDMTI2LjEyNTc0MywyMC45OTQ5MSAxMjYuMTI1NzQzLDIxLjA3NDQ2IDEyNi4xMjU3NDMsMjEuMTU0MzggQzEyNi4xMjU3NDMsMjEuMzkzMDMgMTI1Ljk2NzQ0NiwyMS42MzIwNSAxMjUuNzMwMTg0LDIxLjk1MDYyIEMxMjUuNDkyOTIyLDIyLjI2OTE5IDEyNS4wOTc3MywyMi41ODc3NiAxMjQuNjIzNTczLDIyLjgyNjc4IEMxMjQuMTQ5MDQ4LDIzLjA2NTggMTIzLjU5NTU1OSwyMy4zMDQ4MiAxMjMuMDQyMDcsMjMuMzg0MzcgQzEyMi42NDY4NzgsMjMuNDYzOTIgMTIyLjMzMDY1MSwyMy42MjMzOSAxMjIuMDkzMzg5LDIzLjg2MjA0IEMxMjEuODU2MTI3LDI0LjEwMTA2IDEyMS43NzcxNjIsMjQuNDE5NjMgMTIxLjc3NzE2MiwyNC44OTc2NyBDMTIxLjc3NzE2MiwyNS4zNzUzNCAxMjEuOTM1NDU5LDI1Ljc3MzgzIDEyMi4xNzI3MjEsMjYuMDEyNDggQzEyMi40MDk2MTYsMjYuMjUxNSAxMjIuODA1MTc1LDI2LjQxMDk3IDEyMy4yMDAzNjcsMjYuNDEwOTcgTDEyMy41MTY1OTQsMjYuNDEwOTcgQzEyMy42NzQ1MjQsMjYuNDEwOTcgMTIzLjc1Mzg1NiwyNi40MTA5NyAxMjMuODMyODIxLDI2LjQ5MDUyIEMxMjMuOTExNzg2LDI2LjU3MDA3IDEyMy45MTE3ODYsMjYuNjQ5OTkgMTIzLjkxMTc4NiwyNi44MDkwOSBMMTIzLjkxMTc4NiwyNy4wNDgxMSBDMTIzLjkxMTc4NiwyNy4yMDcyMSAxMjMuOTExNzg2LDI3LjI4NzEzIDEyMy44MzI4MjEsMjcuMzY2NjggQzEyMy43NTM4NTYsMjcuNDQ2MjMgMTIzLjY3NDUyNCwyNy40NDYyMyAxMjMuNTE2NTk0LDI3LjQ0NjIzIEwxMjMuMTIxNDAyLDI3LjQ0NjIzIEMxMjIuMzMwNjUxLDI3LjQ0NjIzIDEyMS42OTgxOTcsMjcuMjA3MjEgMTIxLjMwMzAwNSwyNi43Mjk1NCBDMTIwLjgyODQ4MSwyNi4yNTE1IDEyMC41OTEyMTksMjUuNjE0MzYgMTIwLjU5MTIxOSwyNC44MTgxMiBDMTIwLjU5MTIxOSwyNC4xODA5OCAxMjAuNzQ5NTE2LDIzLjcwMjk0IDEyMC45ODY3NzgsMjMuMzA0ODIgQzEyMC4xMTcwNjIsMjMuMDY1OCAxMTkuNDA1Mjc1LDIyLjU4Nzc2IDExOC44NTIxNTQsMjEuNzkxNTIgQzExOC4yOTg2NjQsMjEuMDc0NDYgMTE4LjA2MTQwMiwyMC4xMTg3NSAxMTcuOTgyNDM3LDE5LjAwMzk0IEwxMTcuOTgyNDM3LDE3LjQxMDcyIEMxMTguMDYxNDAyLDE2LjA1Njg5IDExOC41MzU5MjcsMTUuMDIxNjMgMTE5LjI0NzM0NiwxNC4yMjUwMiBDMTE5Ljk1ODc2NSwxMy40Mjg0MSAxMjAuOTg2Nzc4LDEzLjAzMDI5IDEyMi4xNzI3MjEsMTMuMDMwMjkgQzEyMy41MTY1OTQsMTMuMTg5NzYgMTI0LjU0NDI0LDEzLjU4Nzg4IDEyNS4zMzQ5OTIsMTQuNDY0MDQgTDEyNS4zMzQ5OTIsMTQuNDY0MDQgWiIgaWQ9IkZpbGwtOCI+PC9wYXRoPiAgICAgICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0xMzAuNDczOTU3LDIxLjU1MjUgQzEzMS4wMjc0NDYsMjIuMTEwMDkgMTMxLjczODg2NSwyMi4zNDkxMSAxMzIuNjg3NTQ2LDIyLjM0OTExIEMxMzMuMzk4OTY1LDIyLjM0OTExIDEzMy45NTI0NTQsMjIuMTg5NjQgMTM0LjQyNjk3OCwyMS44NzEwNyBDMTM0LjkwMTEzNSwyMS41NTI1IDEzNS4yMTczNjIsMjEuMDc0NDYgMTM1LjQ1NDYyNCwyMC4zNTc3NyBDMTM1LjUzMzk1NywyMC4xOTg2NyAxMzUuNjEyOTIyLDIwLjExODc1IDEzNS42MTI5MjIsMjAuMDM5MiBDMTM1LjYxMjkyMiwxOS45NTk2NSAxMzUuNzcwODUxLDE5Ljk1OTY1IDEzNS44NTAxODQsMTkuOTU5NjUgTDEzNi4wODcwNzgsMTkuOTU5NjUgQzEzNi4xNjY0MTEsMTkuOTU5NjUgMTM2LjMyNDM0MSwyMC4wMzkyIDEzNi40MDMzMDYsMjAuMTE4NzUgQzEzNi40ODI2MzgsMjAuMTk4NjcgMTM2LjU2MTYwMywyMC4yNzgyMiAxMzYuNDgyNjM4LDIwLjQzNzMyIEMxMzYuNDgyNjM4LDIwLjkxNTM2IDEzNi4zMjQzNDEsMjEuMzkzMDMgMTM2LjAwODExNCwyMS44NzEwNyBDMTM1LjY5MTg4NiwyMi4zNDkxMSAxMzUuMjk2Njk0LDIyLjc0NzIzIDEzNC42NjQyNCwyMi45ODYyNSBDMTM0LjAzMTc4NiwyMy4yMjQ5IDEzMy4zMiwyMy40NjM5MiAxMzIuNTI5NjE2LDIzLjQ2MzkyIEMxMzEuMTg1Mzc2LDIzLjQ2MzkyIDEzMC4xNTc3MywyMy4wNjU4IDEyOS40NDU5NDMsMjIuMjY5MTkgQzEyOC43MzQ1MjQsMjEuNDcyOTUgMTI4LjMzOTMzMiwyMC40MzczMiAxMjguMzM5MzMyLDE5LjAwMzk0IEwxMjguMzM5MzMyLDE3LjQxMDcyIEMxMjguMzM5MzMyLDE1Ljk3NzM0IDEyOC43MzQ1MjQsMTQuOTQxNzEgMTI5LjQ0NTk0MywxNC4xNDU0NyBDMTMwLjE1NzczLDEzLjM0ODg2IDEzMS4xODUzNzYsMTIuOTUwNzQgMTMyLjUyOTYxNiwxMi45NTA3NCBDMTMzLjM5OTMzMiwxMi45NTA3NCAxMzQuMTEwNzUxLDEzLjEwOTg0IDEzNC42NjQyNCwxMy40Mjg0MSBDMTM1LjIxNzM2MiwxMy43NDY5OCAxMzUuNjkxODg2LDE0LjE0NTQ3IDEzNi4wMDgxMTQsMTQuNTQzNTkgQzEzNi4zMjQzNDEsMTUuMDIxNjMgMTM2LjQ4MjYzOCwxNS40OTkzIDEzNi40ODI2MzgsMTUuOTc3MzQgQzEzNi40ODI2MzgsMTYuMDU2ODkgMTM2LjQ4MjYzOCwxNi4yMTYzNiAxMzYuNDAzMzA2LDE2LjI5NTkxIEMxMzYuMzI0MzQxLDE2LjM3NTQ2IDEzNi4yNDUzNzYsMTYuNDU1MDEgMTM2LjA4NzA3OCwxNi40NTUwMSBMMTM1Ljg1MDE4NCwxNi40NTUwMSBDMTM1LjY5MTg4NiwxNi40NTUwMSAxMzUuNjEyOTIyLDE2LjQ1NTAxIDEzNS42MTI5MjIsMTYuMzc1NDYgQzEzNS41MzM5NTcsMTYuMjk1OTEgMTM1LjUzMzk1NywxNi4yMTYzNiAxMzUuNDU0NjI0LDE2LjA1Njg5IEMxMzUuMjE3MzYyLDE1LjM0MDIgMTM0LjgyMjE3LDE0Ljg2MjE2IDEzNC40MjY5NzgsMTQuNTQzNTkgQzEzMy45NTI0NTQsMTQuMjI1MDIgMTMzLjM5ODk2NSwxNC4wNjU1NSAxMzIuNjg3NTQ2LDE0LjA2NTU1IEMxMzEuNzM4ODY1LDE0LjA2NTU1IDEzMS4wMjc0NDYsMTQuMzA0NTcgMTMwLjQ3Mzk1NywxNC44NjIxNiBDMTI5LjkyMDQ2NywxNS40MTk3NSAxMjkuNjgzMjA1LDE2LjI5NTkxIDEyOS42MDQyNCwxNy40MTA3MiBMMTI5LjYwNDI0LDE4LjY4NSBDMTI5LjY4MzIwNSwyMC4xOTg2NyAxMjkuOTk5NDMyLDIwLjk5NDkxIDEzMC40NzM5NTcsMjEuNTUyNSIgaWQ9IkZpbGwtOSI+PC9wYXRoPiAgICAgICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0xNDUuODkwODUxLDE3LjcyOTI5IEwxNDUuODkwODUxLDE3LjcyOTI5IEMxNDUuODkwODUxLDE2LjY5NDAzIDE0NS42NTM1ODksMTUuODE3ODcgMTQ1LjEwMDEsMTUuMTgwNzMgQzE0NC41NDY2MTEsMTQuNTQzNTkgMTQzLjgzNTE5MiwxNC4yMjUwMiAxNDIuODg2NTExLDE0LjIyNTAyIEMxNDEuOTM3ODMsMTQuMjI1MDIgMTQxLjIyNjA0MywxNC41NDM1OSAxNDAuNjcyNTU0LDE1LjE4MDczIEMxNDAuMTE5NDMyLDE1LjgxNzg3IDEzOS44ODIxNywxNi42MTQ0OCAxMzkuODgyMTcsMTcuNjQ5NzQgTDEzOS44ODIxNywxNy43MjkyOSBMMTQ1Ljg5MDg1MSwxNy43MjkyOSBMMTQ1Ljg5MDg1MSwxNy43MjkyOSBaIE0xNDUuODkwODUxLDE0LjQ2NDA0IEMxNDYuNjAyMjcsMTUuMzQwMiAxNDYuOTk3NDYyLDE2LjUzNDkzIDE0Ni45OTc0NjIsMTguMTI3NzggTDE0Ni45OTc0NjIsMTguNDQ2MzUgQzE0Ni45OTc0NjIsMTguNjA1NDUgMTQ2LjkxODQ5NywxOC42ODUgMTQ2LjgzOTUzMywxOC43NjQ5MiBDMTQ2Ljc2MDIsMTguODQ0NDcgMTQ2LjY4MTIzNSwxOC44NDQ0NyAxNDYuNTIzMzA2LDE4Ljg0NDQ3IEwxMzkuNzIzODczLDE4Ljg0NDQ3IEwxMzkuNzIzODczLDE5LjAwMzk0IEMxMzkuNzIzODczLDE5LjY0MTA4IDEzOS44ODIxNywyMC4xOTg2NyAxNDAuMTE5NDMyLDIwLjY3NjM0IEMxNDAuMzU2MzI3LDIxLjIzMzkzIDE0MC43NTE4ODYsMjEuNjMyMDUgMTQxLjE0NzA3OCwyMS45NTA2MiBDMTQxLjYyMTYwMywyMi4yNjkxOSAxNDIuMDk1NzYsMjIuNDI4NjYgMTQyLjcyODIxNCwyMi40Mjg2NiBDMTQzLjQ0LDIyLjQyODY2IDE0My45OTMxMjIsMjIuMjY5MTkgMTQ0LjQ2NzY0NiwyMi4wMzAxNyBDMTQ0Ljk0MTgwMywyMS43OTE1MiAxNDUuMjU4Mzk3LDIxLjQ3Mjk1IDE0NS40MTYzMjcsMjEuMjMzOTMgQzE0NS40OTUyOTIsMjEuMDc0NDYgMTQ1LjY1MzU4OSwyMC45OTQ5MSAxNDUuNjUzNTg5LDIwLjkxNTM2IEMxNDUuNzMyNTU0LDIwLjkxNTM2IDE0NS44MTE1MTksMjAuODM1ODEgMTQ1Ljk2OTgxNiwyMC44MzU4MSBMMTQ2LjI4NjA0MywyMC44MzU4MSBDMTQ2LjM2NTAwOCwyMC44MzU4MSAxNDYuNTIzMzA2LDIwLjgzNTgxIDE0Ni42MDIyNywyMC45MTUzNiBDMTQ2LjY4MTIzNSwyMC45OTQ5MSAxNDYuNjgxMjM1LDIxLjA3NDQ2IDE0Ni42ODEyMzUsMjEuMTU0MzggQzE0Ni42ODEyMzUsMjEuMzkzMDMgMTQ2LjUyMzMwNiwyMS43MTE2IDE0Ni4yMDcwNzgsMjIuMTEwMDkgQzE0NS44OTA4NTEsMjIuNTA4MjEgMTQ1LjQxNjMyNywyMi44MjY3OCAxNDQuNzgzODczLDIzLjA2NTggQzE0NC4xNTE0MTksMjMuMzA0ODIgMTQzLjUxODk2NSwyMy40NjM5MiAxNDIuNzI4MjE0LDIzLjQ2MzkyIEMxNDEuNTQyMjcsMjMuNDYzOTIgMTQwLjUxNDYyNCwyMy4wNjU4IDEzOS44MDMyMDUsMjIuMjY5MTkgQzEzOS4wOTE0MTksMjEuNDcyOTUgMTM4LjYxNzI2MiwyMC40MzczMiAxMzguNTM3OTMsMTkuMDgzNDkgTDEzOC41Mzc5MywxNy40OTA2NCBDMTM4LjYxNzI2MiwxNi4xMzY0NCAxMzkuMDkxNDE5LDE1LjEwMTE4IDEzOS44MDMyMDUsMTQuMzA0NTcgQzE0MC41MTQ2MjQsMTMuNTA4MzMgMTQxLjU0MjI3LDEzLjEwOTg0IDE0Mi43MjgyMTQsMTMuMTA5ODQgQzE0NC4xNTE0MTksMTMuMTg5NzYgMTQ1LjE3OTA2NSwxMy41ODc4OCAxNDUuODkwODUxLDE0LjQ2NDA0IEwxNDUuODkwODUxLDE0LjQ2NDA0IFoiIGlkPSJGaWxsLTEwIj48L3BhdGg+ICAgICAgICAgICAgICAgICAgICAgICAgPHBhdGggZD0iTTE1MC45NTA0ODQsMTEuMTk4NDIgQzE1MC44NzE1MTksMTEuMjc3OTcgMTUwLjc5MjU1NCwxMS4yNzc5NyAxNTAuNjM0MjU3LDExLjI3Nzk3IEwxNDkuOTIyODM4LDExLjI3Nzk3IEMxNDkuNzY0NTQxLDExLjI3Nzk3IDE0OS42ODU1NzYsMTEuMjc3OTcgMTQ5LjYwNjYxMSwxMS4xOTg0MiBDMTQ5LjUyNzY0NiwxMS4xMTg4NyAxNDkuNTI3NjQ2LDExLjAzOTMyIDE0OS41Mjc2NDYsMTAuODc5ODUgTDE0OS41Mjc2NDYsMTAuMTYzMTYgQzE0OS41Mjc2NDYsMTAuMDAzNjkgMTQ5LjUyNzY0Niw5LjkyNDE0IDE0OS42MDY2MTEsOS44NDQ1OSBDMTQ5LjY4NTU3Niw5Ljc2NDY3IDE0OS43NjQ1NDEsOS42ODUxMiAxNDkuOTIyODM4LDkuNjg1MTIgTDE1MC42MzQyNTcsOS42ODUxMiBDMTUwLjc5MjU1NCw5LjY4NTEyIDE1MC44NzE1MTksOS43NjQ2NyAxNTAuOTUwNDg0LDkuODQ0NTkgQzE1MS4wMjk4MTYsOS45MjQxNCAxNTEuMTA4NzgxLDEwLjAwMzY5IDE1MS4xMDg3ODEsMTAuMTYzMTYgTDE1MS4xMDg3ODEsMTAuODc5ODUgQzE1MS4xMDg3ODEsMTEuMDM5MzIgMTUxLjAyOTgxNiwxMS4xMTg4NyAxNTAuOTUwNDg0LDExLjE5ODQyIEwxNTAuOTUwNDg0LDExLjE5ODQyIFogTTE0OS44NDM4NzMsMTMuNTA4MzMgQzE0OS45MjI4MzgsMTMuNDI4NDEgMTUwLjAwMTgwMywxMy40Mjg0MSAxNTAuMTYwMSwxMy40Mjg0MSBMMTUwLjQ3NjMyNywxMy40Mjg0MSBDMTUwLjYzNDI1NywxMy40Mjg0MSAxNTAuNzEzNTg5LDEzLjQyODQxIDE1MC43OTI1NTQsMTMuNTA4MzMgQzE1MC44NzE1MTksMTMuNTg3ODggMTUwLjg3MTUxOSwxMy42Njc0MyAxNTAuODcxNTE5LDEzLjgyNjkgTDE1MC44NzE1MTksMjMuNzgyNDkgQzE1MC44NzE1MTksMjQuODE4MTIgMTUwLjYzNDI1NywyNS42MTQzNiAxNTAuMjM5MDY1LDI2LjE3MTk1IEMxNDkuODQzODczLDI2LjcyOTU0IDE0OS4wNTMxMjIsMjcuMDQ4MTEgMTQ4LjAyNTQ3NiwyNy4wNDgxMSBMMTQ3Ljk0NjE0NCwyNy4wNDgxMSBDMTQ3Ljc4ODIxNCwyNy4wNDgxMSAxNDcuNzA5MjQ5LDI3LjA0ODExIDE0Ny42Mjk5MTcsMjYuOTY4NTYgQzE0Ny41NTA5NTIsMjYuODg4NjQgMTQ3LjU1MDk1MiwyNi44MDkwOSAxNDcuNTUwOTUyLDI2LjY0OTk5IEwxNDcuNTUwOTUyLDI2LjQxMDk3IEMxNDcuNTUwOTUyLDI2LjI1MTUgMTQ3LjU1MDk1MiwyNi4xNzE5NSAxNDcuNjI5OTE3LDI2LjA5MjQgQzE0Ny43MDkyNDksMjYuMDEyNDggMTQ3Ljc4ODIxNCwyNi4wMTI0OCAxNDcuOTQ2MTQ0LDI2LjAxMjQ4IEwxNDguMDI1NDc2LDI2LjAxMjQ4IEMxNDguNzM2ODk1LDI2LjAxMjQ4IDE0OS4yMTE0MTksMjUuODUzMzggMTQ5LjM2OTM0OSwyNS40NTUyNiBDMTQ5LjYwNjYxMSwyNS4wNTY3NyAxNDkuNjg1NTc2LDI0LjU3OTEgMTQ5LjY4NTU3NiwyMy44NjI0MSBMMTQ5LjY4NTU3NiwxMy45MDY0NSBDMTQ5LjY4NTU3NiwxMy42Njc0MyAxNDkuNzY0NTQxLDEzLjUwODMzIDE0OS44NDM4NzMsMTMuNTA4MzMgTDE0OS44NDM4NzMsMTMuNTA4MzMgWiIgaWQ9IkZpbGwtMTEiPjwvcGF0aD4gICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTY2Ljk5OTgzMywyMy4yMjQ5IEMxNjYuOTIwODY4LDIzLjMwNDgyIDE2Ni44NDE5MDMsMjMuMzA0ODIgMTY2LjY4MzYwNiwyMy4zMDQ4MiBMMTY2LjM2NzM3OSwyMy4zMDQ4MiBDMTY2LjIwOTQ0OSwyMy4zMDQ4MiAxNjYuMTMwMTE3LDIzLjMwNDgyIDE2Ni4wNTExNTIsMjMuMjI0OSBDMTY1Ljk3MjE4NywyMy4xNDUzNSAxNjUuOTcyMTg3LDIzLjA2NTggMTY1Ljk3MjE4NywyMi45MDYzMyBMMTY1Ljk3MjE4NywxNy41NzAxOSBDMTY1Ljk3MjE4NywxNi41MzQ5MyAxNjUuNzM0OTI1LDE1LjczODMyIDE2NS4xODE0MzYsMTUuMTgwNzMgQzE2NC43MDcyNzksMTQuNjIzMTQgMTYzLjk5NTQ5MiwxNC4zMDQ1NyAxNjMuMDQ2ODExLDE0LjMwNDU3IEMxNjIuMDk4MTMsMTQuMzA0NTcgMTYxLjM4NjcxMSwxNC42MjMxNCAxNjAuODMzMjIyLDE1LjE4MDczIEMxNjAuMjc5NzMzLDE1LjczODMyIDE2MC4wNDI0NzEsMTYuNTM0OTMgMTYwLjA0MjQ3MSwxNy41NzAxOSBMMTYwLjA0MjQ3MSwyMi45MDYzMyBDMTYwLjA0MjQ3MSwyMy4wNjU4IDE2MC4wNDI0NzEsMjMuMTQ1MzUgMTU5Ljk2MzUwNiwyMy4yMjQ5IEMxNTkuODg0NTQxLDIzLjMwNDgyIDE1OS44MDUyMDksMjMuMzA0ODIgMTU5LjY0NzI3OSwyMy4zMDQ4MiBMMTU5LjMzMTA1MiwyMy4zMDQ4MiBDMTU5LjE3Mjc1NSwyMy4zMDQ4MiAxNTkuMDkzNzksMjMuMzA0ODIgMTU5LjAxNDgyNSwyMy4yMjQ5IEMxNTguOTM1ODYsMjMuMTQ1MzUgMTU4LjkzNTg2LDIzLjA2NTggMTU4LjkzNTg2LDIyLjkwNjMzIEwxNTguOTM1ODYsMTMuNzQ2OTggQzE1OC45MzU4NiwxMy41ODc4OCAxNTguOTM1ODYsMTMuNTA4MzMgMTU5LjAxNDgyNSwxMy40Mjg0MSBDMTU5LjA5Mzc5LDEzLjM0ODg2IDE1OS4xNzI3NTUsMTMuMzQ4ODYgMTU5LjMzMTA1MiwxMy4zNDg4NiBMMTU5LjY0NzI3OSwxMy4zNDg4NiBDMTU5LjgwNTIwOSwxMy4zNDg4NiAxNTkuODg0NTQxLDEzLjM0ODg2IDE1OS45NjM1MDYsMTMuNDI4NDEgQzE2MC4wNDI0NzEsMTMuNTA4MzMgMTYwLjA0MjQ3MSwxMy41ODc4OCAxNjAuMDQyNDcxLDEzLjc0Njk4IEwxNjAuMDQyNDcxLDE0LjYyMzE0IEMxNjAuNDM4MDMsMTQuMTQ1NDcgMTYwLjgzMzIyMiwxMy43NDY5OCAxNjEuMzg2NzExLDEzLjUwODMzIEMxNjEuODYwODY4LDEzLjI2OTMxIDE2Mi40OTMzMjIsMTMuMTA5ODQgMTYzLjI4NDA3MywxMy4xMDk4NCBDMTY0LjU0ODk4MiwxMy4xMDk4NCAxNjUuNDk3NjYzLDEzLjUwODMzIDE2Ni4xMzAxMTcsMTQuMzA0NTcgQzE2Ni44NDE5MDMsMTUuMTAxMTggMTY3LjE1ODEzLDE2LjEzNjQ0IDE2Ny4xNTgxMywxNy40MTA3MiBMMTY3LjE1ODEzLDIyLjgyNjc4IEMxNjcuMTU4MTMsMjMuMDY1OCAxNjcuMDc4Nzk4LDIzLjE0NTM1IDE2Ni45OTk4MzMsMjMuMjI0OSIgaWQ9IkZpbGwtMTIiPjwvcGF0aD4gICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTcxLjE5MDExNywyMy4yMjQ5IEMxNzEuMTExMTUyLDIzLjMwNDgyIDE3MS4wMzE4MiwyMy4zMDQ4MiAxNzAuODczODksMjMuMzA0ODIgTDE3MC41NTc2NjMsMjMuMzA0ODIgQzE3MC4zOTkzNjYsMjMuMzA0ODIgMTcwLjMyMDQwMSwyMy4zMDQ4MiAxNzAuMjQxNDM2LDIzLjIyNDkgQzE3MC4xNjI0NzEsMjMuMTQ1MzUgMTcwLjE2MjQ3MSwyMy4wNjU4IDE3MC4xNjI0NzEsMjIuOTA2MzMgTDE3MC4xNjI0NzEsMTMuNzQ2OTggQzE3MC4xNjI0NzEsMTMuNTg3ODggMTcwLjE2MjQ3MSwxMy41MDgzMyAxNzAuMjQxNDM2LDEzLjQyODQxIEMxNzAuMzIwNDAxLDEzLjM0ODg2IDE3MC4zOTkzNjYsMTMuMzQ4ODYgMTcwLjU1NzY2MywxMy4zNDg4NiBMMTcwLjg3Mzg5LDEzLjM0ODg2IEMxNzEuMDMxODIsMTMuMzQ4ODYgMTcxLjExMTE1MiwxMy4zNDg4NiAxNzEuMTkwMTE3LDEzLjQyODQxIEMxNzEuMjY5MDgyLDEzLjUwODMzIDE3MS4yNjkwODIsMTMuNTg3ODggMTcxLjI2OTA4MiwxMy43NDY5OCBMMTcxLjI2OTA4MiwyMi45MDYzMyBDMTcxLjI2OTA4MiwyMy4wNjU4IDE3MS4yNjkwODIsMjMuMTQ1MzUgMTcxLjE5MDExNywyMy4yMjQ5IEwxNzEuMTkwMTE3LDIzLjIyNDkgWiBNMTcxLjQyNzM3OSwxMS4xOTg0MiBDMTcxLjM0ODA0NywxMS4yNzc5NyAxNzEuMjY5MDgyLDExLjI3Nzk3IDE3MS4xMTExNTIsMTEuMjc3OTcgTDE3MC4zOTkzNjYsMTEuMjc3OTcgQzE3MC4yNDE0MzYsMTEuMjc3OTcgMTcwLjE2MjQ3MSwxMS4yNzc5NyAxNzAuMDgzMTM5LDExLjE5ODQyIEMxNzAuMDA0MTc0LDExLjExODg3IDE3MC4wMDQxNzQsMTEuMDM5MzIgMTcwLjAwNDE3NCwxMC44Nzk4NSBMMTcwLjAwNDE3NCwxMC4xNjMxNiBDMTcwLjAwNDE3NCwxMC4wMDM2OSAxNzAuMDA0MTc0LDkuOTI0MTQgMTcwLjA4MzEzOSw5Ljg0NDU5IEMxNzAuMTYyNDcxLDkuNzY0NjcgMTcwLjI0MTQzNiw5LjY4NTEyIDE3MC4zOTkzNjYsOS42ODUxMiBMMTcxLjExMTE1Miw5LjY4NTEyIEMxNzEuMjY5MDgyLDkuNjg1MTIgMTcxLjM0ODA0Nyw5Ljc2NDY3IDE3MS40MjczNzksOS44NDQ1OSBDMTcxLjUwNjM0NCw5LjkyNDE0IDE3MS41ODUzMDksMTAuMDAzNjkgMTcxLjU4NTMwOSwxMC4xNjMxNiBMMTcxLjU4NTMwOSwxMC44Nzk4NSBDMTcxLjUwNjM0NCwxMS4wMzkzMiAxNzEuNTA2MzQ0LDExLjExODg3IDE3MS40MjczNzksMTEuMTk4NDIgTDE3MS40MjczNzksMTEuMTk4NDIgWiIgaWQ9IkZpbGwtMTMiPjwvcGF0aD4gICAgICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMTc4LjMwNTQwOSwxMS4zNTc4OSBDMTc4LjIyNjQ0NCwxMS40Mzc0NCAxNzguMTQ3NDc5LDExLjQzNzQ0IDE3Ny45ODkxODIsMTEuNDM3NDQgTDE3Ny4wNDA1MDEsMTEuNDM3NDQgQzE3Ni44ODI1NzEsMTEuNDM3NDQgMTc2LjgwMzIzOSwxMS40Mzc0NCAxNzYuNzI0Mjc0LDExLjM1Nzg5IEMxNzYuNjQ1MzA5LDExLjI3Nzk3IDE3Ni42NDUzMDksMTEuMTk4NDIgMTc2LjY0NTMwOSwxMS4wMzkzMiBMMTc2LjY0NTMwOSwxMC4wODMyNCBDMTc2LjY0NTMwOSw5LjkyNDE0IDE3Ni42NDUzMDksOS44NDQ1OSAxNzYuNzI0Mjc0LDkuNzY0NjcgQzE3Ni44MDMyMzksOS42ODUxMiAxNzYuODgyNTcxLDkuNjA1NTcgMTc3LjA0MDUwMSw5LjYwNTU3IEwxNzcuOTg5MTgyLDkuNjA1NTcgQzE3OC4xNDc0NzksOS42MDU1NyAxNzguMjI2NDQ0LDkuNjg1MTIgMTc4LjMwNTQwOSw5Ljc2NDY3IEMxNzguMzg0NzQxLDkuODQ0NTkgMTc4LjQ2MzcwNiw5LjkyNDE0IDE3OC40NjM3MDYsMTAuMDgzMjQgTDE3OC40NjM3MDYsMTEuMDM5MzIgQzE3OC40NjM3MDYsMTEuMTk4NDIgMTc4LjM4NDc0MSwxMS4yNzc5NyAxNzguMzA1NDA5LDExLjM1Nzg5IEwxNzguMzA1NDA5LDExLjM1Nzg5IFogTTE4MS4zMDk3NSwyMi4zNDkxMSBDMTgxLjM4ODcxNSwyMi40Mjg2NiAxODEuMzg4NzE1LDIyLjUwODIxIDE4MS4zODg3MTUsMjIuNjY3MzEgTDE4MS4zODg3MTUsMjIuOTA2MzMgQzE4MS4zODg3MTUsMjMuMDY1OCAxODEuMzg4NzE1LDIzLjE0NTM1IDE4MS4zMDk3NSwyMy4yMjQ5IEMxODEuMjMwNzg1LDIzLjMwNDgyIDE4MS4xNTE4MiwyMy4zMDQ4MiAxODAuOTkzNTIzLDIzLjMwNDgyIEwxNzQuMDM2MTYsMjMuMzA0ODIgQzE3My44NzgyMywyMy4zMDQ4MiAxNzMuNzk4ODk4LDIzLjMwNDgyIDE3My43MTk5MzMsMjMuMjI0OSBDMTczLjY0MDk2OCwyMy4xNDUzNSAxNzMuNjQwOTY4LDIzLjA2NTggMTczLjY0MDk2OCwyMi45MDYzMyBMMTczLjY0MDk2OCwyMi41ODc3NiBDMTczLjY0MDk2OCwyMi40Mjg2NiAxNzMuNzE5OTMzLDIyLjI2OTE5IDE3My44NzgyMywyMi4wMzA1NCBMMTc5LjQ5MTM1MiwxNC41NDM1OSBMMTc0LjI3MzQyMiwxNC41NDM1OSBDMTc0LjExNTQ5MiwxNC41NDM1OSAxNzQuMDM2MTYsMTQuNTQzNTkgMTczLjk1NzE5NSwxNC40NjQwNCBDMTczLjg3ODIzLDE0LjM4NDQ5IDE3My44NzgyMywxNC4zMDQ1NyAxNzMuODc4MjMsMTQuMTQ1NDcgTDE3My44NzgyMywxMy45MDY0NSBDMTczLjg3ODIzLDEzLjc0Njk4IDE3My44NzgyMywxMy42Njc0MyAxNzMuOTU3MTk1LDEzLjU4Nzg4IEMxNzQuMDM2MTYsMTMuNTA4MzMgMTc0LjExNTQ5MiwxMy41MDgzMyAxNzQuMjczNDIyLDEzLjUwODMzIEwxODAuNjc3Mjk1LDEzLjUwODMzIEMxODAuODM1NTkzLDEzLjUwODMzIDE4MC45MTQ1NTgsMTMuNTA4MzMgMTgwLjk5MzUyMywxMy41ODc4OCBDMTgxLjA3MjQ4NywxMy42Njc0MyAxODEuMDcyNDg3LDEzLjc0Njk4IDE4MS4wNzI0ODcsMTMuOTA2NDUgTDE4MS4wNzI0ODcsMTQuMjI1MDIgQzE4MS4wNzI0ODcsMTQuMzg0NDkgMTgwLjk5MzUyMywxNC41NDM1OSAxODAuODM1NTkzLDE0Ljc4MjYxIEwxNzUuMzAxMDY4LDIyLjI2OTE5IEwxODEuMDcyNDg3LDIyLjI2OTE5IEMxODEuMTUxODIsMjIuMTg5NjQgMTgxLjIzMDc4NSwyMi4yNjkxOSAxODEuMzA5NzUsMjIuMzQ5MTEgTDE4MS4zMDk3NSwyMi4zNDkxMSBaIiBpZD0iRmlsbC0xNCI+PC9wYXRoPiAgICAgICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0xOTcuMTIxODM2LDIxLjc5MTUyIEMxOTcuMjAwODAxLDIxLjg3MTA3IDE5Ny4yODAxMzQsMjIuMDMwNTQgMTk3LjI4MDEzNCwyMi4xODk2NCBMMTk3LjI4MDEzNCwyMi45MDYzMyBDMTk3LjI4MDEzNCwyMy4wNjU4IDE5Ny4yMDA4MDEsMjMuMTQ1MzUgMTk3LjEyMTgzNiwyMy4zMDQ4MiBDMTk3LjA0Mjg3MSwyMy4zODQzNyAxOTYuODg0NTc0LDIzLjQ2MzkyIDE5Ni43MjY2NDQsMjMuNDYzOTIgTDE4OC45Nzg1MzEsMjMuNDYzOTIgQzE4OC44MjA2MDEsMjMuNDYzOTIgMTg4Ljc0MTYzNiwyMy4zODQzNyAxODguNTgzMzM5LDIzLjMwNDgyIEMxODguNTA0Mzc0LDIzLjIyNDkgMTg4LjQyNTQwOSwyMy4wNjU4IDE4OC40MjU0MDksMjIuOTA2MzMgTDE4OC40MjU0MDksMTAuNDgxNzMgQzE4OC40MjU0MDksMTAuMzIyMjYgMTg4LjUwNDM3NCwxMC4yNDI3MSAxODguNTgzMzM5LDEwLjA4MzI0IEMxODguNjYyMzA0LDEwLjAwMzY5IDE4OC44MjA2MDEsOS45MjQxNCAxODguOTc4NTMxLDkuOTI0MTQgTDE4OS43NjkyODIsOS45MjQxNCBDMTg5LjkyNzU3OSw5LjkyNDE0IDE5MC4wMDY1NDQsMTAuMDAzNjkgMTkwLjE2NDQ3NCwxMC4wODMyNCBDMTkwLjI0MzgwNiwxMC4xNjMxNiAxOTAuMzIyNzcxLDEwLjMyMjI2IDE5MC4zMjI3NzEsMTAuNDgxNzMgTDE5MC4zMjI3NzEsMjEuNjMyMDUgTDE5Ni44MDU2MDksMjEuNjMyMDUgQzE5Ni44ODQ1NzQsMjEuNjMyMDUgMTk2Ljk2MzkwNywyMS42MzIwNSAxOTcuMTIxODM2LDIxLjc5MTUyIiBpZD0iRmlsbC0xNSI+PC9wYXRoPiAgICAgICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0yMDEuMDc0ODU4LDIxLjYzMjA1IEwyMDcuNDc4NzMxLDIxLjYzMjA1IEMyMDcuNjM3MDI4LDIxLjYzMjA1IDIwNy43MTU5OTMsMjEuNzExNiAyMDcuODc0MjksMjEuNzkxNTIgQzIwNy45NTMyNTUsMjEuODcxMDcgMjA4LjAzMjIyLDIyLjAzMDU0IDIwOC4wMzIyMiwyMi4xODk2NCBMMjA4LjAzMjIyLDIyLjkwNjMzIEMyMDguMDMyMjIsMjMuMDY1OCAyMDcuOTUzMjU1LDIzLjE0NTM1IDIwNy44NzQyOSwyMy4zMDQ4MiBDMjA3Ljc5NDk1OCwyMy4zODQzNyAyMDcuNjM3MDI4LDIzLjQ2MzkyIDIwNy40Nzg3MzEsMjMuNDYzOTIgTDE5OS43MzA5ODUsMjMuNDYzOTIgQzE5OS41NzI2ODgsMjMuNDYzOTIgMTk5LjQ5MzcyMywyMy4zODQzNyAxOTkuMzM1NzkzLDIzLjMwNDgyIEMxOTkuMjU2NDYxLDIzLjIyNDkgMTk5LjE3NzQ5NiwyMy4wNjU4IDE5OS4xNzc0OTYsMjIuOTA2MzMgTDE5OS4xNzc0OTYsMTAuNDgxNzMgQzE5OS4xNzc0OTYsMTAuMzIyMjYgMTk5LjI1NjQ2MSwxMC4yNDI3MSAxOTkuMzM1NzkzLDEwLjA4MzI0IEMxOTkuNDE0NzU4LDEwLjAwMzY5IDE5OS41NzI2ODgsOS45MjQxNCAxOTkuNzMwOTg1LDkuOTI0MTQgTDIwNy4yNDE4MzYsOS45MjQxNCBDMjA3LjM5OTc2Niw5LjkyNDE0IDIwNy40Nzg3MzEsMTAuMDAzNjkgMjA3LjYzNzAyOCwxMC4wODMyNCBDMjA3LjcxNTk5MywxMC4xNjMxNiAyMDcuNzk0OTU4LDEwLjMyMjI2IDIwNy43OTQ5NTgsMTAuNDgxNzMgTDIwNy43OTQ5NTgsMTEuMTk4NDIgQzIwNy43OTQ5NTgsMTEuMzU3ODkgMjA3LjcxNTk5MywxMS40Mzc0NCAyMDcuNjM3MDI4LDExLjU5NjU0IEMyMDcuNTU4MDYzLDExLjY3NjQ2IDIwNy4zOTk3NjYsMTEuNzU2MDEgMjA3LjI0MTgzNiwxMS43NTYwMSBMMjAwLjk5NTg5MywxMS43NTYwMSBMMjAwLjk5NTg5MywxNS44MTc4NyBMMjA2Ljg0NjI3NywxNS44MTc4NyBDMjA3LjAwNDU3NCwxNS44MTc4NyAyMDcuMDgzNTM5LDE1Ljg5NzQyIDIwNy4yNDE4MzYsMTUuOTc3MzQgQzIwNy4zMjA4MDEsMTYuMDU2ODkgMjA3LjM5OTc2NiwxNi4yMTYzNiAyMDcuMzk5NzY2LDE2LjM3NTQ2IEwyMDcuMzk5NzY2LDE3LjA5MjE1IEMyMDcuMzk5NzY2LDE3LjI1MTYyIDIwNy4zMjA4MDEsMTcuMzMxMTcgMjA3LjI0MTgzNiwxNy40OTA2NCBDMjA3LjE2MjUwNCwxNy41NzAxOSAyMDcuMDA0NTc0LDE3LjY0OTc0IDIwNi44NDYyNzcsMTcuNjQ5NzQgTDIwMC45OTU4OTMsMTcuNjQ5NzQgTDIwMC45OTU4OTMsMjEuNjMyMDUgTDIwMS4wNzQ4NTgsMjEuNjMyMDUiIGlkPSJGaWxsLTE2Ij48L3BhdGg+ICAgICAgICAgICAgICAgICAgICAgICAgPHBhdGggZD0iTTIxOS44MTIzMjEsMjIuNTg3NzYgQzIxOS45NzAyNSwyMi43NDcyMyAyMTkuOTcwMjUsMjIuODI2NzggMjE5Ljk3MDI1LDIyLjkwNjMzIEMyMTkuOTcwMjUsMjIuOTg2MjUgMjE5Ljg5MTI4NSwyMy4xNDUzNSAyMTkuODEyMzIxLDIzLjIyNDkgQzIxOS43MzMzNTYsMjMuMzA0ODIgMjE5LjY1NDAyMywyMy4zODQzNyAyMTkuNDk2MDkzLDIzLjM4NDM3IEwyMTguMzEwMTUsMjMuMzg0MzcgQzIxOC4wNzI4ODgsMjMuMzg0MzcgMjE3LjgzNTYyNiwyMy4zMDQ4MiAyMTcuNTk4NzMxLDIzLjA2NTggTDIxMi4yMjI1MDQsMTcuODg4NzYgTDIxMi4yMjI1MDQsMjIuODI2NzggQzIxMi4yMjI1MDQsMjIuOTg2MjUgMjEyLjE0MzUzOSwyMy4wNjU4IDIxMi4wNjQyMDcsMjMuMjI0OSBDMjExLjk4NTI0MiwyMy4zMDQ4MiAyMTEuODI3MzEyLDIzLjM4NDM3IDIxMS42NjkwMTUsMjMuMzg0MzcgTDIxMC44Nzg2MzEsMjMuMzg0MzcgQzIxMC43MjAzMzQsMjMuMzg0MzcgMjEwLjY0MTM2OSwyMy4zMDQ4MiAyMTAuNDgzMDcyLDIzLjIyNDkgQzIxMC40MDQxMDcsMjMuMTQ1MzUgMjEwLjMyNTE0MiwyMi45ODYyNSAyMTAuMzI1MTQyLDIyLjgyNjc4IEwyMTAuMzI1MTQyLDEwLjQwMTgxIEMyMTAuMzI1MTQyLDEwLjI0MjcxIDIxMC40MDQxMDcsMTAuMTYzMTYgMjEwLjQ4MzA3MiwxMC4wMDM2OSBDMjEwLjU2MjQwNCw5LjkyNDE0IDIxMC43MjAzMzQsOS44NDQ1OSAyMTAuODc4NjMxLDkuODQ0NTkgTDIxMS42NjkwMTUsOS44NDQ1OSBDMjExLjgyNzMxMiw5Ljg0NDU5IDIxMS45MDYyNzcsOS45MjQxNCAyMTIuMDY0MjA3LDEwLjAwMzY5IEMyMTIuMTQzNTM5LDEwLjA4MzI0IDIxMi4yMjI1MDQsMTAuMjQyNzEgMjEyLjIyMjUwNCwxMC40MDE4MSBMMjEyLjIyMjUwNCwxNC44NjIxNiBMMjE3LjI4MjUwNCwxMC4xNjMxNiBDMjE3LjQ0MDQzNCwxMC4wMDM2OSAyMTcuNjc3Njk2LDkuODQ0NTkgMjE3Ljk5MzkyMyw5Ljg0NDU5IEwyMTkuMTAwOTAyLDkuODQ0NTkgQzIxOS4xNzk4NjYsOS44NDQ1OSAyMTkuMzM3Nzk2LDkuOTI0MTQgMjE5LjQxNzEyOSwxMC4wMDM2OSBDMjE5LjQ5NjA5MywxMC4wODMyNCAyMTkuNTc1MDU4LDEwLjE2MzE2IDIxOS41NzUwNTgsMTAuMzIyMjYgQzIxOS41NzUwNTgsMTAuNDAxODEgMjE5LjQ5NjA5MywxMC41NjEyOCAyMTkuNDE3MTI5LDEwLjY0MDgzIEwyMTMuMzI5NDgyLDE2LjI5NTkxIEwyMTkuODEyMzIxLDIyLjU4Nzc2IiBpZD0iRmlsbC0xNyI+PC9wYXRoPiAgICAgICAgICAgICAgICAgICAgPC9nPiAgICAgICAgICAgICAgICA8L2c+ICAgICAgICAgICAgPC9nPiAgICAgICAgPC9nPiAgICA8L2c+PC9zdmc+);
			height: 50px;
			width: 100%;
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
		}
	</style>
</head>
<body>
	<div style="padding: 0 20px; max-width: 700px; margin: 0 auto;">
		<div style="padding: 20px 0 5px;">
			<div style="text-align: center;" class="gmail-sucks"></div>
		</div>
		<div>
			@yield('content')
		</div>
		<p><em>Ekipa Więcej niż LEK</em></p>
		<div style="text-align: center; font-size: 10px; margin-top: 40px; padding: 15px 0; border-top: 1px solid #efefef;">
			<p>Ta wiadomość została wysłana na adres %recipient_email%<br>
			Jeżeli nie chcesz otrzymywać od nas wiadomości, <a href="%mailing_list_unsubscribe_url%">kliknij tu, aby zrezygnować</a>.</p>
			<p>&copy; by bethink sp. z o.o., Wszystkie prawa zastrzeżone<br>
			ul. Henryka Sienkiewicza 8/1, 60-817 Poznań<br>
			KRS: 0000668811, NIP: 781-194-37-56</p>
		</div>
	</div>
</body>
</html>

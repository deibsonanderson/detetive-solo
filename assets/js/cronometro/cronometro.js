/*
//ESSE BLOCO ABAIXO FAZ O CONOMETRO FUNCIONAR DE FORMA CRESCENTE
"use strict";

let hour = 0;
let minute = 0;
let second = 0;
let millisecond = 0;

let cron;

document.form_main.start.onclick = () => cronometroStart();
document.form_main.pause.onclick = () => cronometroPause();
document.form_main.reset.onclick = () => cronometroReset();

function cronometroStart() {
	cronometroPause();
	cron = setInterval(() => { cronometroTimer(); }, 10);
}

function cronometroPause() {
	clearInterval(cron);
}

function cronometroReset() {
	hour = 0;
	minute = 0;
	second = 0;
	millisecond = 0;
	document.getElementById('hour').innerText = '00';
	document.getElementById('minute').innerText = '00';
	document.getElementById('second').innerText = '00';
	document.getElementById('millisecond').innerText = '000';
}

function cronometroTimer() {
	if ((millisecond += 10) == 1000) {
		millisecond = 0;
		second++;
	}
	if (second == 60) {
		second = 0;
		minute++;
	}
	if (minute == 60) {
		minute = 0;
		hour++;
	}
	document.getElementById('hour').innerText = returnData(hour);
	document.getElementById('minute').innerText = returnData(minute);
	document.getElementById('second').innerText = returnData(second);
	document.getElementById('millisecond').innerText = returnData(millisecond);
}

function returnData(input) {
	return input >= 10 ? input : `0${input}`
}
*/

//ESSE BLOCO ABAIXO FAZ O CONOMETRO FUNCIONAR DE FORMA DESCRESCENTE
"use strict";

let hour = 0;
let minute = 0;
let second = 30;
let millisecond = 0;
let cron;

function cronometroStart(link) {
	cronometroPause();
	$('#pause-btn').attr('onclick', 'cronometroPause();');
	$('#pause-btn').html('Pausar ');
	cron = setInterval(() => { cronometroTimer(link); }, 10);
}

function cronometroPause() {
	clearInterval(cron);
	$('#pause-btn').attr('onclick', 'cronometroStart();');
	$('#pause-btn').html('Iniciar');
}

function cronometroReset() {
	hour = 23;
	minute = 59;
	second = 59;
	millisecond = 0;
	updateDisplay();
}

function cronometroTimer(link) {
	if ((millisecond -= 10) < 0) {
		millisecond = 990;
		if (--second < 0) {
			second = 59;
			if (--minute < 0) {
				minute = 59;
				if (--hour < 0) {
					// Zera o cronômetro quando o tempo acaba
					cronometroPause();
					hour = 0;
					minute = 0;
					second = 0;
					millisecond = 0;
					
					if(link == undefined){
						location.reload();
					} else{
						location = link;
					}
				}
			}
		}
	}
	updateDisplay();
}

function updateDisplay() {
	//document.getElementById('hour').innerText = returnData(hour);
	document.getElementById('minute').innerText = returnData(minute);
	document.getElementById('second').innerText = returnData(second);
	//document.getElementById('millisecond').innerText = returnMilli(millisecond);
}

function returnData(input) {
	return input >= 10 ? input : `0${input}`;
}

function returnMilli(input) {
	return input.toString().padStart(3, '0');
}
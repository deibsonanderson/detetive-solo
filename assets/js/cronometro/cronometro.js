"use strict";

let hour = 0;
let minute = 0;
let second = 30;
let millisecond = 999;
let cron;

function cronometroStart(link) {
	cronometroPause();
	$('#pause-btn').attr('onclick', 'cronometroPause();');
	$('#pause-btn').html('<img width="85" src="./assets/imagens/pausar.png" class="img-fluid">');
	cron = setInterval(() => { cronometroTimer(link); }, 10);
}

function cronometroPause() {
	clearInterval(cron);
	$('#pause-btn').attr('onclick', 'cronometroStart();');
	$('#pause-btn').html('<img width="85" src="./assets/imagens/executar.png" class="img-fluid">');
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
	document.getElementById('minute').innerText = returnData(minute);
	document.getElementById('second').innerText = returnData(second);
	var muli = returnData(millisecond);	
	document.getElementById('millisecond').innerText = (muli < 100)?'0'+muli:muli;
}

function returnData(input) {
	return input >= 10 ? input : `0${input}`;
}

function returnMilli(input) {
	return input.toString().padStart(3, '0');
}
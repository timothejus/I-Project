/**
 * Created by Tim Hendriksen on 2-12-2016.
 */
function setTimer(elem_id, date) {
// set the date we're counting down to
    var target_date = new Date(date).getTime();
    // variables for time units
    var days, hours, minutes, seconds;
    // get tag element

    var countDownElem = document.getElementById(elem_id);
    //update the tag with id "countdown" every 1 second
    setInterval(function () {
        // find the amount of "seconds" between now and target
        var current_date = new Date().getTime();
        var seconds_left = (target_date - current_date) / 1000;
        // do some time calculations
        days = parseInt(seconds_left / 86400);
        seconds_left = seconds_left % 86400;
        hours = parseInt(seconds_left / 3600);
        seconds_left = seconds_left % 3600;
        minutes = parseInt(seconds_left / 60);
        seconds = parseInt(seconds_left % 60);
        // format countdown string + set tag value
        if(days == 0){
            if(hours == 0) {
                if (minutes == 0) {
                    if (seconds <= 0) {
                        countDownElem.innerHTML = "AFGELOPEN";
                    } else {
	                    countDownElem.innerHTML = seconds + "s";
                    }
                }else{
                    countDownElem.innerHTML = minutes + "m " + seconds + "s";
                }
            }else{
                countDownElem.innerHTML =  hours + "h " + minutes + "m " + seconds + "s";
            }
        }else{
            countDownElem.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s";
        }

    }, 1000);
}



function parseMillisecondsIntoReadableTime(milliseconds){
    //Get hours from milliseconds
    var hours = milliseconds / (1000*60*60);
    var h = Math.floor(hours);
  
    //Get remainder from hours and convert to minutes
    var minutes = (hours - h) * 60;
    var m = Math.floor(minutes);
  
    //Get remainder from minutes and convert to seconds
    //var seconds = (minutes - m) * 60;
    //var s = Math.floor(seconds);                          
  
    return h + 'h ' + m + 'min'; // ' ' + s + 'sec';
}

function displayRemainingTimeUntilCreditsReset()
{
    var today = new Date();
    today.setUTCDate(today.getUTCDate());
    var tomorrow = new Date();
    tomorrow.setUTCDate(tomorrow.getUTCDate() + 1);
    tomorrow.setUTCHours(0, 0, 0, 0);
    var diff = (tomorrow-today); // difference in milliseconds
    var time_left = parseMillisecondsIntoReadableTime(diff);

    var credits_reset = document.getElementById('credits_reset');
    if(typeof(credits_reset) != 'undefined' && credits_reset != null)
    {
        var width = screen.width;
        if(width > 400)
        { 
            credits_reset.innerHTML = "Credits left for today: ";
        }
        else
        {
            document.getElementById('credits_reset').setAttribute("visibility", "hidden");
        }
    }

    var credits_reset = document.getElementById('credits_reset_account_page');
    if(typeof(credits_reset_account_page) != 'undefined' && credits_reset_account_page != null)
    {
        credits_reset_account_page.innerHTML = time_left;
    }

    var credits_reset_error_message = document.getElementById('credits_reset_error_message');
    if(typeof(credits_reset_error_message) != 'undefined' && credits_reset_error_message != null)
    {
        credits_reset_error_message.innerHTML = 'Your credits will reset in '+time_left+'.';
    }

    setTimeout(displayRemainingTimeUntilCreditsReset, 60000);
}

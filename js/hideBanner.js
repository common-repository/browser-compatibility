function hideBanner()
{
	var banner = document.getElementById('chk_brwsr_compat');
	close_flag = 1;
	banner.style.display = 'none';
	document.cookie = "banner=hidden; path=/";
	return close_flag;
}
function Set_Cookie(name, value, expires, path, domain, secure) {
    // set time, it's in milliseconds
    var today = new Date();
    today.setTime(today.getTime());
    // if the expires variable is set, make the correct expires time, the
    // current script below will set it for x number of days, to make it
    // for hours, delete * 24, for minutes, delete * 60 * 24
    if (expires)
    {
        //expires = expires * 1000 * 60 * 60 * 24;
        expires = expires * 1000 * 60;
    }
    //alert( 'today ' + today.toGMTString() );// this is for testing purpose only
    var expires_date = new Date(today.getTime() + (expires));
    //alert('expires ' + expires_date.toGMTString());// this is for testing purposes only

    document.cookie = name + "=" + escape(value) +
            ((expires) ? ";expires=" + expires_date.toGMTString() : "") + //expires.toGMTString()
            ((path) ? ";path=" + path : "") +
            ((domain) ? ";domain=" + domain : "") +
            ((secure) ? ";secure" : "");
}

function clearText(element){if($(element).val()=='enter your email')
{$(element).val('');}}

function replaceText(element){if($(element).val()=='')
{$(element).val('enter your email');}}

function unhide(divID) {
    var item = document.getElementById(divID);
    if (item) { 
    	item.className=(item.className=='hidden')?'unhidden':'hidden';
    }
}

function hideunhide(hideDivID, unhideDivID) {
    var item = document.getElementById(hideDivID);
    if (item) { 
    	item.className='hidden';
    }
    
    var item = document.getElementById(unhideDivID);
    if (item) { 
    	item.className='unhidden';
    }
}

$(document).ready(function() {
    $("body").fadeIn(400);

$('#myCarousel').carousel()
$('#newProductCar').carousel()

/* Drop down hover */
$(".oh-dropdown").mouseover(function(event){
    $(this).addClass("open");
});
$(".oh-dropdown").mouseout(function(event){
    $(this).removeClass("open");
});

/* Home page item price animation */
$('.thumbnail').mouseenter(function() {
   $(this).children('.zoomTool').fadeIn();
});

$('.thumbnail').mouseleave(function() {
	$(this).children('.zoomTool').fadeOut();
});

// Show/Hide Sticky "Go to top" button
	$(window).scroll(function(){
		if($(this).scrollTop()>200){
			$(".gotop").fadeIn(200);
		}
		else{
			$(".gotop").fadeOut(200);
		}
	});
// Scroll Page to Top when clicked on "go to top" button
	$(".gotop").click(function(event){
		event.preventDefault();
		scrollTo(document.documentElement, 0, 400);
	});

});

function scrollTo(element, to, duration) {
    var start = element.scrollTop,
        change = to - start,
        increment = 20;

    var animateScroll = function(elapsedTime) {        
        elapsedTime += increment;
        var position = easeInOut(elapsedTime, start, change, duration);                        
        element.scrollTop = position; 
        if (elapsedTime < duration) {
            setTimeout(function() {
                animateScroll(elapsedTime);
            }, increment);
        }
    };

    animateScroll(0);
}

function easeInOut(currentTime, start, change, duration) {
    currentTime /= duration / 2;
    if (currentTime < 1) {
        return change / 2 * currentTime * currentTime + start;
    }
    currentTime -= 1;
    return -change / 2 * (currentTime * (currentTime - 2) - 1) + start;
}

function togglePassword() {
    var p = document.getElementById("inputPassword");
    var e = document.getElementById("eye");
    if (p.type === "password") {
        p.type = "text";
        e.classList.remove("icon-eye-open");
        e.classList.add("icon-eye-close");
    } else {
        p.type = "password";
        e.classList.remove("icon-eye-close");
        e.classList.add("icon-eye-open");
    }
}

function onImageChange() {
    var txtImage = document.getElementById("input-image");
    var fileImage = document.getElementById("imgUpload");
    var filename = fileImage.value.replace(/^.*[\\\/]/, '');
    txtImage.value = filename;
}

function clearFields() {
    var frm = document.getElementById("frmCp");
    var x = frm.elements;
    for (i=0; i<x.length; i++) {
        type = x[i].type.toLowerCase();
        switch (type)
        {
        case "text": case "number": case "textarea":
            x[i].value="";
            break;
        case "select-one": case "select-multi":
            x[i].selectedIndex = 0;
            break;
        default:
            break;
        }
    }
}
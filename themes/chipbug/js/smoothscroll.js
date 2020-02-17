jQuery(document).ready(set_up);


function set_up() {
    //jQuery('a[href*="#"]:not([href="#"])').on('click', smooth_scroll);
}

function smooth_scroll(e) {
    e.preventDefault();
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
        var target = jQuery(this.hash);
        target = target.length ? target : jQuery('[id=' + this.hash.slice(1) + ']');
        if (target.length && target !=='top') {
            jQuery('html, body').animate({
                scrollTop: target.offset().top - 70
            }, 1000);
            return false;
        } else if(target.length) {
            jQuery('html, body').animate({
                scrollTop: target.offset().top - 140
            }, 1000);
            return false;
        }
    }
}

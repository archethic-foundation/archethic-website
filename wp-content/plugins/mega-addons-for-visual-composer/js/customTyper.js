// Typed Text
jQuery(document).ready(function($) {
    jQuery('.type-wrap').each(function(index, el) {
        var typed = $(this).find('.typed');
        var shahzaib_cont = $(this).find('.typed-strings');
        var typespeed = $(this).data('typespeed');
        var backspeed = $(this).data('backspeed');
        var loop = false;
        if($(this).attr('data-loop') == ''){
            loop = true;
        } else {
            loop = false;
        }
        // console.log(loop);
        typed.typed({
            // strings: ["Typed.js is a <strong>jQuery</strong> plugin.", "It <em>types</em> out sentences.", "And then deletes them.", "Try it out!"],
            stringsElement: shahzaib_cont,
            typeSpeed: parseInt(typespeed),
            backDelay: parseInt(backspeed),
            loop: loop,
            showCursor: false,
            contentType: 'html', // or text
            // defaults to false for infinite loop
            loopCount: loop,
            callback: function(){ foo(); },
            resetCallback: function() { newTyped(); }
        });

        
        
    });

    /*jQuery(".reset").click(function(){
        $("#typed").typed('reset');
    });*/

    function newTyped(){ /* A new typed object */ }

    function foo(){ console.log("Callback"); }
});
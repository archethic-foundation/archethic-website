jQuery(document).ready(function(){

    var sandwiches = document.querySelectorAll('.maw_portfolioGallery_container');

    sandwiches.forEach(function (sandwich, index) {

        var mixer = mixitup(sandwich, {
            animation: {
                effects: "fadeIn",
                perspectiveDistance: "10px",
                perspectiveOrigin: "50% 50%",
                animateResizeContainer: false // required to prevent column algorithm bug
            },
            controls: {
                scope: 'local'
            }
        });

        // console.log(sandwich); // The element
        // console.log(index); // The index in the NodeList
    });

});

        var current_price=0;
        var current_circulating_supply=0;
 async function getstats()
{
   

        const response1 = await fetch('https://api.coingecko.com/api/v3/simple/price?ids=uniris&vs_currencies=usd');
        const data1 = await response1.json();
        current_price=data1.uniris.usd;
        console.log(current_price);

        const response2 = await fetch('https://ck7163lr1l.execute-api.us-east-1.amazonaws.com/default/uniris_circulating_supply');
        const data2 = await response2.json();
        current_circulating_supply=data2.circulating_supply;
        console.log(current_circulating_supply);
        
}

async function displaystats() {  
    await  getstats();
    console.log(current_price,current_circulating_supply);
    document.querySelector("#live-feed-price").innerText = current_price;
    document.querySelector("#current-circulating-supply").innerText =  calc_M_or_B(current_circulating_supply);
    let current_market_cap = current_circulating_supply*current_price;
    document.querySelector("#current-market-cap").innerText =  calc_M_or_B(current_market_cap);

}

displaystats();

// $(window).scroll(function () {
//         if ($(window).scrollTop() >= 1) {
//         $('.scheme_default .sc_layouts_row_fixed_on').css( "background:rgba(0,0,0,0.1)");
//         } else {

//                 $('.scheme_default .sc_layouts_row_fixed_on').css( "background:rgba(0,0,0,0.1)");
//         }
//         });

function calc_M_or_B(x) {
	if(isNaN(x)) return x;

	if(x < 9999) {
		return x;
	}

	if(x < 1000000) {
		return Math.round(x/1000) + "K";
	}
	if( x < 10000000) {
		return (x/1000000).toFixed(2) + "M";
	}

	if(x < 1000000000) {
		return Math.round((x/1000000)) + "M";
	}

	if(x < 1000000000000) {
		return Math.round((x/1000000000)) + "B";
	}

	return "1T+";
}
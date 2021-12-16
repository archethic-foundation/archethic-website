var current_price = 0,
 current_circulating_supply = 0,
 market_cap=0;

async function getstats() {
    const e = await fetch("https://api.coingecko.com/api/v3/simple/price?ids=archethic&vs_currencies=usd"),
        t = await e.json();
    current_price = t.archethic.usd;
    const c = await fetch("https://ck7163lr1l.execute-api.us-east-1.amazonaws.com/default/uniris_circulating_supply"),
        r = await c.json();
    current_circulating_supply = r.circulating_supply;
    market_cap = current_price*current_circulating_supply;
    
}
async function displaystats() {
    await getstats(); 
    document.querySelector("#live-feed-price").innerText = current_price;
    document.querySelector("#current-circulating-supply").innerText = calc_M_or_B(current_circulating_supply);
    document.querySelector("#market-cap").innerText = calc_M_or_B(market_cap);
}

function calc_M_or_B(e) {
    return isNaN(e) ? e : e < 9999 ? e : e < 1e6 ? Math.round(e / 1e3) + "K" : e < 1e7 ? (e / 1e6).toFixed(2) + "M" : e < 1e9 ? Math.round(e / 1e6) + "M" : e < 1e12 ? Math.round(e / 1e9) + "B" : "1T+"
}

let promise =displaystats();
promise.then(
    function(value) {  },
    function(error) { }
  );
 
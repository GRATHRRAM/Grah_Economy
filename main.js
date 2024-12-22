var cash = 1000;

document.getElementById("Balance").textContent = "Balance: " + cash.toString() + "$";

function GetCash() {
	cash += 500;
	document.getElementById("Balance").textContent = "Balance: " + cash.toString() + "$";
}

function SiteReg() {
	window.location.replace("register/register.html");
}

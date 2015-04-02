(function()
{
	window.lib = {};

	var msgboxElement = document.getElementById("msgbox");
	var msgboxCallback;
	lib.msgbox = function(message, cb)
	{
		msgboxCallback = cb;
		msgboxElement.querySelector(".content").innerHTML = message;
		msgboxElement.className = "active";
	}

	msgboxElement.querySelector(".button-cancel").addEventListener("click", function()
	{
		msgboxElement.className = "";
	});

	msgboxElement.querySelector(".button-ok").addEventListener("click", function()
	{
		msgboxElement.className = "";
		if (msgboxCallback) msgboxCallback();
	});
})();

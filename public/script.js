(function()
{
	window.lib = {};

	var elemMsgbox = document.getElementById("msgbox");
	lib.msgbox = function(message, cb)
	{
		elemMsgbox.querySelector(".content").innerHTML = message;
		elemMsgbox.className = "";

		elemMsgbox.querySelector(".button-cancel").addEventListener("click", function()
		{
			elemMsgbox.className = "hidden";
		});

		elemMsgbox.querySelector(".button-ok").addEventListener("click", function()
		{
			elemMsgbox.className = "hidden";
			if (cb) cb();
		});
	}
})();

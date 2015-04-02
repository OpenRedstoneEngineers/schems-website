(function()
{
	window.lib = {};

	var elemMsgbox = document.getElementById("msgbox");
	lib.msgbox = function(message, cb)
	{
		elemMsgbox.querySelector(".content").innerHTML = message;
		elemMsgbox.className = "active";

		elemMsgbox.querySelector(".button-cancel").addEventListener("click", function()
		{
			elemMsgbox.className = "";
		});

		elemMsgbox.querySelector(".button-ok").addEventListener("click", function()
		{
			elemMsgbox.className = "";
			if (cb) cb();
		});
	}
})();

var LOG = true;
var DEBUG = true;

var HogLog = {

	i: function(what) {
		if (LOG)
			console.log("INFO: " + what);
	},
	w: function(what) {
		if (LOG)
			console.log("WARNING: " + what);
	},
	d: function(what) {
		if (LOG && DEBUG)
			console.log("DEBUG: " + what)
	}
};
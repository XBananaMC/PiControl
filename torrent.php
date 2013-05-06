<script src="jquery-1.9.1.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
	function search() {
		$.get(
		    "http://torrentz.eu/", {},
		    function(dat) {
		        document.getElementById("searchField").innerHTML = dat;
		    }
		);
		//document.getElementById("searchField").value
	}
</script>

<div class="block">
	<input type="text" name="search" id="searchField">
	<button type="button" onclick="search()">Search</button>
</div>

<div class="block" id="torrentPage">
	<object data="http://torrentz.eu/">
</div>
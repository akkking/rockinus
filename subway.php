<html>
  <head>
<script src="subway.js"></script>

  </head>
  <body>
 <form name="myForm">
  <div>&nbsp;&nbsp;&nbsp;&nbsp;
    train lines:<select name="line" style= "width:170" onchange="changestops(this.value)">
      <option value="0">--please choose the line--</option>
      <option value="1">1</option>
	  <option value="2">2</option>
	  <option value="3">3</option>
	  <option value="4">4</option>
	  <option value="5">5</option>
	  <option value="6">6</option>
	  <option value="7">7</option>
	  <option value="A">A</option>
	  <option value="C">C</option>
	  <option value="E">E</option>
	  <option value="B">B</option>
	  <option value="D">D</option>
	  <option value="F">F</option>
	  <option value="M">M</option>
	  <option value="G">G</option>
	  <option value="J">J</option>
	  <option value="Z">Z</option>
	  <option value="N">N</option>
	  <option value="Q">Q</option>
	  <option value="R">R</option>
	  <option value="L">L</option>
	  <option value="S">S</option>
      </select>
	  stops:<select disabled="disabled" name="stops" style= "width:180">
      <option>--please choose the stops--</option>
      </select>
  </div>
 </form>
  </body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html><head>
<title>CSS Menu without JavaScript, PureCSS, Hidden, Mouseover-Effect</title>
<style type="text/css">
ul {
  font-family: Arial, Verdana;
  font-size: 14px;
  margin: 0;
  padding: 0;
  list-style: none;
}
ul li {
  display: block;
  position: relative;
  float: left;
}
li ul { display: none; }
ul li a {
  display: block;
  text-decoration: none;
  color: #ffffff;
  border-top: 1px solid #ffffff;
  padding: 5px 15px 5px 15px;
  background: #2C5463;
  margin-left: 1px;
  white-space: nowrap;
}
ul li a:hover { background: #617F8A; }
li:hover ul {
  display: block;
  position: absolute;
}
li:hover li {
  float: none;
  font-size: 11px;
}
li:hover a { background: #617F8A; }
li:hover li a:hover { background: #95A9B1; }
</style>

</head><body>
<div style="padding: 0 0 0 120px;">
<ul id="menu">
  <li><a href="">Home</a></li>
  <li><a href="">About Us</a>
    <ul>
    <li><a href="">The Team</a></li>
    <li><a href="">History</a></li>
    <li><a href="">Vision</a></li>
    </ul>
  </li>
  <li><a href="">Products</a>
    <ul>
    <li><a href="">Cozy Couch</a></li>
    <li><a href="">Great Table</a></li>
    <li><a href="">Small Chair</a></li>
    <li><a href="">Shiny Shelf</a></li>
    <li><a href="">Invisible Nothing</a></li>
    </ul>
  </li>
  <li><a href="">Contact</a>
    <ul>
    <li><a href="">Online</a></li>
    <li><a href="">Right Here</a></li>
    <li><a href="">Somewhere Else</a></li>
    </ul>
  </li>
</ul>
</div>
</body></html>
//<script type='text/javascript'>//javascript
function highlightSearch() 
{
    var text = document.getElementById("search_name").value;
    var search_name = new RegExp("(\\b" + text + "\\b)", "gim");
    var e = document.getElementById("searchtext").innerHTML;
    var enew = e.replace(/(<span>|<\/span>)/igm, "");
    document.getElementById("searchtext").innerHTML = enew;
    var newe = enew.replace(search_name, "<span>$1</span>");
    document.getElementById("searchtext").innerHTML = newe;
}
/*!--}//css
<!--'#searchtext span
'<!--{
'    background-color:#FF9;  
'    color:#555;
'}
'div {
'    padding: 10px; 
'}-->//html-->-->
<!--/*<div><h2>Find and highlight text in document</h2>
<form action="" method="" id="search" name="search">
<input name="query" id="query" type="text" size="30" maxlength="30">
<input name="searchit" type="button" value="Search" onClick="highlightSearch()">
</form></div>*/-->

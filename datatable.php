<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Solange Leite">
<meta name="creation-date" content="01/09/2014">
<title>Datatable</title>
<script type="text/javascript" src="YUI/2.6.0/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="YUI/2.6.0/build/element/element-beta-min.js"></script>
<script type="text/javascript" src="YUI/2.6.0/build/datasource/datasource-min.js"></script>
<script type="text/javascript" src="YUI/2.6.0/build/datatable/datatable-min.js"></script>
<link rel="stylesheet" type="text/css" href="YUI/2.6.0/build/fonts/fonts-min.css" />
<link rel="stylesheet" type="text/css" href="YUI/2.6.0/build/datatable/assets/skins/sam/datatable.css" />
<style type="text/css">

body {
	margin:0;
	padding:0;
}

.yui-dt table
{
    width: 50%;
}
.yui-dt th { 
	text-align:center;
}

.yui-skin-sam .yui-dt td.align-right {
	    text-align:right;
}
.yui-skin-sam .yui-dt td.align-center {
	    text-align:center;
}
</style>
</head>
<body class="yui-skin-sam">
<div align="center">
  <h2>Simple example of sorting field with Brazilian date format</h2>
</div>
<div id="paginated">
  <table width="50%" border="1" cellpadding="0" cellspacing="0" id="yuidatatable1_data" align="center">
    <thead>
      <tr>
      	<td align="center">
        Nome
        </td>
        <td align="center">
        Data
        </td>
      </tr>
    </thead>
    <tbody>
    <?php $cont = 0; do{ 
		$dia = date("d");
		if( $dia < 10){
			$data= "0".($dia+$cont).'/'.date("m").'/'.date("Y").date(" H:i:s");
		}else{
			$data= date("d")+$cont.'/'.date("m").'/'.date("Y").date(" H:i:s");
		}?>	
      <tr>
      	<td align="center">
        Solange
        </td>
        <td align="center" valign="middle"><?php echo $data; ?></td>
      </tr>
      <?php $cont = $cont+1;} while ($cont<3); ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">			
YAHOO.util.Event.addListener(window, "load", function() {
	
	var sortData = function(a, b, desc) { 
	
		// Deal with empty values 		
		if(!YAHOO.lang.isValue(a)) { 
			return (!YAHOO.lang.isValue(b)) ? 0 : 1; 
		} 
		else if(!YAHOO.lang.isValue(b)) { 
			return -1; 
		} 	 
		// First compare by state 
		var comp = YAHOO.util.Sort.compare; 
		var dataa1= a.getData("Data").substring(0,10);
		var dataa2= b.getData("Data").substring(0,10);
		var dia = dataa1.split("/")[0].toString();
		var mes = dataa1.split("/")[1].toString();
		var ano = dataa1.split("/")[2].toString();
		var dia2 = dataa2.split("/")[0].toString();
		var mes2 = dataa2.split("/")[1].toString();
		var ano2 = dataa2.split("/")[2].toString();
		var diatotal = parseInt(dia+mes+ano);
		var diatotal2 = parseInt(dia+mes2+ano2);
		var d2=new Date(dataa1.split("/")[2], (dataa1.split("/")[1])-1, dataa1.split("/")[0]);
		var d1=new Date(dataa2.split("/")[2], (dataa2.split("/")[1])-1, dataa2.split("/")[0]);
		var dias = (Math.ceil((d1.getTime()-d2.getTime())/1000/60/60/24));
		var compState = comp(d1.getTime(), d2.getTime(), desc); 
		// If states are equal, then compare by areacode 
		return (compState !== 0) ? compState : comp(a.getData("Nome"), b.getData("Nome"), desc); 
	};			
			
	var cols = [
		{key:"Nome", label:"Nome", sortable:true, allowHTML: true, width:220, className: 'align-center'},
		{key:"Data", label:"Data", sortable:true, allowHTML: true, sortOptions:{sortFunction:sortData}, className: 'align-right'}
	];	
	
	YAHOO.example.ClientPagination = function() {
	
	var dataSource = new YAHOO.util.DataSource(YAHOO.util.Dom.get("yuidatatable1_data"),{
		responseType : YAHOO.util.DataSource.TYPE_HTMLTABLE,
		responseSchema : {
			fields : [
			{key:"Nome"},
			{key:"Data"}
			]
		}
	});
	
	var dataTable = new YAHOO.widget.DataTable('paginated',cols,dataSource);   
	
	return {
			oDS: dataSource,
			oDT: dataTable
		};
	}();
});
</script>
</body>
</html>
function annotateAllX(area,ctx,data,statData,posi,posj,othervars) {
	retstring='<B><U>'+statData[posi][posj].v2+'</U></B><BR>';
	for(var i=data.datasets.length-1;i>=0;i--){
		if(typeof statData[i][posj].datavalue!="undefined" && data.datasets[i].type != "Line"){
			var boxLegend="<canvas id=\"canvas_Line"+posi+"_"+posj+"\" height=\"10\" width=\"30\" style=\"border:1px solid black; background : "+data.datasets[i].fillColor+"\"></canvas>";
			retstring=retstring+boxLegend+" "+statData[i][posj].v1+"="+statData[i][posj].datavalue+"<BR>";
		}
	}
	return "<%='"+retstring+"'%>".replace(/<BR>/g," ");

}

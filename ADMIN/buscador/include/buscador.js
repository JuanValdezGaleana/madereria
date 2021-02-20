function xmlhttp(){
		var xmlhttp;
		try{xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");}
		catch(e){
			try{xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
			catch(e){
				try{xmlhttp = new XMLHttpRequest();}
				catch(e){
					xmlhttp = false;
				}
			}
		}
		if (!xmlhttp) 
				return null;
			else
				return xmlhttp;
	}

function buscar(clave_venta){
		var clave_venta;
		var query = document.getElementById('q').value;
		var A = document.getElementById('resultados');
		var B = document.getElementById('loading');
		var ajax = xmlhttp();

		ajax.onreadystatechange=function(){
				if(ajax.readyState==1){
						B.innerHTML = "<img src='images/loading.gif' alg='Loading...'>";
					}
				if(ajax.readyState==4){
						A.innerHTML = ajax.responseText;
						B.innerHTML = "";
					}
			}
		ajax.open("GET","busqueda.php?clave_venta='JUANNN'&q="+encodeURIComponent(query),true);
		ajax.send(null);
		return false;
	}
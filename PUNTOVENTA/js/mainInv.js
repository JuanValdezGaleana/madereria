$(function(){

    var espLoading=$('#espLoading');

    espLoading.html('<div class="col-12 text-center m-3 text-primary"><h3>Cargando datos...</h3></div>');
    $('#tbProductos tbody').empty();
    $.ajax({
        url:'php/mainInv.php?op=1',
        dataType:'JSON',
        success:function(data){},
        error:function(error){
            console.error('ERROR:',error);
        }
    }).done(function(data){
       
        $('#tbProductos tbody').empty();
        $.each(data,function(ind,val){
            $('#tbProductos tbody').append('<tr>'+
                '<td id="tdCodBarras'+val.id_producto+'">'+val.cve_producto+'</td>'+
                '<td id="tddescripcion'+val.id_producto+'">'+val.descripcion+'</td>'+
                '<td align="right" id="tdPrecVent'+val.id_producto+'">'+val.precio_venta+'</td>'+
                '<td align="right" id="tdCantAct'+val.id_producto+'">'+val.cantidad_actual+'</td>'+
                '<td><a href="#" id="det'+val.id_producto+'" onclick="detalleProducto('+val.id_producto+')">Detalle</a></td>'+
            '</tr>');
        });

        $(document).ready(function() {
            $('#tbProductos').DataTable();
        } );

        espLoading.empty();
        $('#espBtnExcel').html('<button id="DLtoExcel" class="btn btn-outline-success"><div class="fa fa-clipboard"> </div> Exportar lista del inventario a Excel</button>');
        inventarioFinal();

    }).fail(function(error){
        console.error('FAIL:',error);
    });

    var frmUpdProd=$('#frmUpdProd');

    /* Submit para actualizar inventario */
    frmUpdProd.on('submit',function(){
        event.preventDefault();

        $.ajax({
            url:'php/mainInv.php?op=3',
            data:frmUpdProd.serialize(),
            dataType:'JSON',
            type:'POST',
            success:function(data){},
            error:function(error){
                console.error('ERROR:',error);
            }
        }).done(function(data){
           
            $.each(data,function(ind,val){
               if(val.stat==1){
                    $('#tdPrecVent'+val.idProd).text(val.precUnitVenta);
                    $('#tdCantAct'+val.idProd).text(val.cantidad);

                    $('#tdCodBarras'+val.idProd).text(val.codBarras);
                    $('#tddescripcion'+val.idProd).text(val.descripcion);

                    $('#modalDetalleProd').modal('hide');
                    $('#toastSuccess').toast('show');
               }
            });
    
          
    
        }).fail(function(error){
            console.error('FAIL:',error);
        });


    });


});



function detalleProducto(id_producto){
    event.preventDefault();
    //$('#modalContent').empty();

    //$('#modalContent').append('');



    $.ajax({
        url:'php/mainInv.php?op=2',
        data:'id_producto='+id_producto,
        dataType:'JSON',
        type:'POST',
        success:function(data){},
        error:function(error){
            console.error('ERROR:',error);
        }
    }).done(function(data){
        $.each(data,function(ind,val){
            $('#idProd').val(val.id_producto);
            $('#codBarras').val(val.cve_producto);
            $('#nomProd').val(val.nombre_producto);
            $('#descripcion').val(val.descripcion);
            $('#precUnitVenta').val(val.precio_venta);
            $('#cantidad').val(val.cantidad_actual);
            
            
        });
    }).fail(function(error){
        console.error('FAIL:',error);
    });





    $('#modalDetalleProd').modal('show');
}




function alert_mensaje(lugar,tipo,cadena){
    lugar.append('<div id="alert_msj" class="alert '+tipo+'" >'+cadena+'</div>');
}


function inventarioFinal(){
    
    $.ajax({
        url:'php/mainInv.php?op=4',
        dataType:'JSON',
        success:function(data){},
        error:function(error){
            console.error('ERROR:',error);
        }
    }).done(function(data){
       
        excel(data);

    }).fail(function(error){
        console.error('FAIL:',error);
    });
}


function excel(data){
    var $btnDLtoExcel = $('#DLtoExcel');
    //$('#cargando').remove();
    $btnDLtoExcel.removeAttr('disabled');
    $btnDLtoExcel.on('click', function () {
  
        
        var obj=data;
        //console.log('arreglo: '+obj);
  
          $("#dvjson").excelexportjs({
                    containerid: "dvjson"
                       , datatype: 'json'
                       , dataset: obj
                       , columns: getColumns(obj)     
                });
  
    });
  
  
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);
  
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
}
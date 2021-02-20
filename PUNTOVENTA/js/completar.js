$(function(){

    $('#esp_cargando').html('<div class="spinner-grow text-info" role="status">'+
        '<span class="sr-only">Loading...</span>'+
        '</div><div class="spinner-grow text-info" role="status">'+
        '<span class="sr-only">Loading...</span>'+
        '</div><div class="spinner-grow text-info" role="status">'+
        '<span class="sr-only">Loading...</span>'+
        '</div>');

  
    $('#lista_productos').empty();

    $.ajax({
        url:'php/lista_productos.php?op=1',
        dataType:'JSON',
        error:function(error){
            console.error('ERROR:',error);
        }
        
    }).done(function(data){
        $.each(data,function(index,val){
            
            $('#lista_productos').append('<option value="'+val.descripcion+'">');
            
        });
        
        $('#cont_gral').show();
        //$('#btn_registrar').show();
        //$('#esp_cargando').empty();
        buscar_cod();
    }).fail(function(error){
        console.error('Fail: ',error);
    });

    

    
});


function buscar_cod(){
    $('#prod_select').on('change',function(){
        $('#msj_buscar').empty();
        $('#cant_disponible').empty();
        $('#b_codigo').val('');
        
        var prod_select=$(this).val();
        //console.log('Producto: ',prod_select);
        $.ajax({
            url:'php/lista_productos.php?op=2',
            data:'descripcion='+prod_select,
            dataType:'JSON',
            type:'POST'
            
        }).done(function(data){
            //console.log('CODIGO: ',data);
            $('#idProd').val('');
            $('#codBarras').val('');
            $('#nomProd').val('');
            $.each(data,function(index,val){
                $('#msj_buscar').empty();
                $('#idProd').val(val.id_producto);
                $('#codBarras').val(val.cve_producto);
                $('#nomProd').val(prod_select);
                $('#precVenta').val(val.precio_venta);
                $('#precUnitVenta').val(val.precio_venta);
                //$('#cant_disponible').html(' (Cantidad disponible: '+val.cantidad+')');
                //$('#cantidad').attr('autofocus','autofocus');
            });
            
        }).fail(function(error){
            console.error('Fail: ',error);
        });

    });
}




$(function(){

    var b_codigo=$('#b_codigo');

    var codBarras=$('#codBarras');
    var nomProd=$('#nomProd');
    
    var esp_mensajes=$('#msj_buscar');

    b_codigo.on('change',function(){
        $('div').remove('#alert_msj');
        $('#prod_select').val('');
        $.ajax({
            url:'php/mainFact.php?op=1',
            data:'cod='+b_codigo.val(),
            dataType:'JSON',
            type:'POST',
            success:function(data){
                codBarras.val('');
               if(data=='' || data==null){
                   console.log('No hay dato');
                   alert_mensaje(esp_mensajes,"alert-danger",'No existe el producto en el sistema');
                   $('#idProd').val('');id_producto
                   $('#codBarras').val('');
                   $('#nomProd').val('');
                   $('#precVenta').val('');
               }else{
                $.each(data,function(index,val){
                    $('#idProd').val(val.id_producto);
                    $('#codBarras').val(val.cve_producto);
                    $('#nomProd').val(val.descripcion);
                    $('#precVenta').val(val.precio_venta);
                    $('#precUnitVenta').val(val.precio_venta);

                });
             
            }
    
            },
            error:function(error){
                console.error('ERROR: ',error);
            }
        }).done(function(data){
    
        }).fail(function(error){
            console.error('FAIL: ' ,error);
            $("#msj_buscar").html('<div class="alert alert-danger">'+error+'</div>')
        });
    });


});



$(function(){

    var frmNuevaFact=$('#frmNuevaFact');

    frmNuevaFact.on('submit',function(){
        event.preventDefault();
        $('#msjGuardado').empty();
        $.ajax({
            url:'php/mainFact.php?op=2',
            data:frmNuevaFact.serialize(),
            dataType:'JSON',
            type:'POST',
            success:function(data){
                
            },
            error:function(error){
                console.error('ERROR:',error);
            }
        }).done(function(data){
            console.log('Datos guardados');
            $.each(data,function(ind,val){
                if(val.stat==1){
                    $('#b_codigo').val('');
                    $('#prod_select').val('');
                    $('#codBarras').val('');
                    $('#nomProd').val('');
                    $('#precVenta').val('');
                    $('#cantidad').val('');
                    $('#precUnitCompra').val('');
                    $('#precUnitVenta').val('');
                    $('#tpFact').prop('checked',false);
                    $('#tpNoFact').prop('checked',false);
                    alert_mensaje($('#msjGuardado'),'alert-success','Se han guardado los datos')
                }
            });
        }).fail(function(error){
            console.error('FAIL:',error);
        });
    });

    $('#tbFacturas tbody').empty();
    $.ajax({
        url:'php/mainFact.php?op=3',
        dataType:'JSON',
        success:function(data){},
        error:function(error){
            console.error('ERROR:',error);
        }
    }).done(function(data){
        //console.log('Cargando facturas',data);
        $('#tbFacturas tbody').empty();
        $.each(data,function(ind,val){
            $('#tbFacturas tbody').append('<tr>'+
                '<td>'+val.inm_num_factura+'</td>'+
                '<td>'+val.cve_producto+'</td>'+
                '<td>'+val.descripcion+'</td>'+
                '<td>'+val.fecha_alta+'</td>'+
                '<td><a href="#" id="det'+val.inm_id+'" onclick="detalleFactura('+val.inm_id+')">Detalle</a></td>'+
            '</tr>');
        });
        $('#tbFacturas').DataTable();
    }).fail(function(error){
        console.error('FAIL:',error);
    });

});

function detalleFactura(inm_id){
    event.preventDefault();
    $('#modalContent').empty();

    $('#modalContent').append('<div class="modal-header">'+
    '<h5 class="modal-title" id="modalTitle">Detalle</h5>'+
    '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
        '<span aria-hidden="true">&times;</span>'+
    '</button>'+
    '</div>'+
    '<div class="modal-body" id="modalBody">'+
    '<form class="row" id="frmNuevaFact" method="POST">'+
        '<div class="form-group">'+
            '<input type="hidden" class="form-control" name="idProd" id="idProd"  required>'+
        '</div>'+
        '<div class="form-group">'+
            '<input type="hidden" class="form-control" name="idInm" id="idInm"  required>'+
        '</div>'+
        '<div class="form-group col-12">'+
            '<label for="">Código de barras</label>'+
            '<input type="text" class="form-control" name="codBarras" id="codBarras" required disabled>'+
        '</div>'+
        '<div class="form-group col-12">'+
            '<label for="">Producto</label>'+
            '<input type="text" class="form-control" name="nomProd" id="nomProd" required disabled>'+
        '</div>'+
        '<div class="form-group col-4">'+
            '<label for="">Folio/número de factura</label>'+
            '<input type="text" class="form-control" name="numFact" id="numFact" required>'+
        '</div>'+
        '<div class="form-group col-4">'+
            '<label for="">Cantidad</label>'+
            '<input type="number" class="form-control" name="cantidad" id="cantidad" required>'+
        '</div>'+
        '<div class="form-group col-4">'+
            '<label for="">Precio unitario de compra</label>'+
            '<input type="number" class="form-control" name="precUnitCompra" id="precUnitCompra" required>'+
        '</div>'+
        '<div class="form-group col-4">'+
            '<label for="">Precio unitario de venta</label>'+
            '<input type="number" class="form-control" name="precUnitVenta" id="precUnitVenta" required>'+
        '</div>'+
        
        '<div class="form-group col-4">'+
            '<label for="">Factura</label>'+
            '<div class="form-check">'+
                '<input class="form-check-input" type="radio" name="tipoFact" id="tpFact" value="1" required>'+
                '<label class="form-check-label" for="tpFact">'+
                'Facturado'+
                '</label>'+
            '</div>'+
            
            '<div class="form-check">'+
                '<input class="form-check-input" type="radio" name="tipoFact" id="tpNoFact" value="2">'+
                '<label class="form-check-label" for="tpNoFact">'+
                'No facturado'+
                '</label>'+
            '</div>'+
        '</div>'+
        
        '<!--<div class="col-12 text-center">'+
            '<button type="submit" class="btn btn-success">Actualizar</button>'+
        '</div>-->'+
        '<div class="col-12" id="msjGuardado"></div>'+
    
    '</form>'+
    '</div>'+
    '<div class="modal-footer" id="modalFooter">'+
    '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>'+
    '</div>');



    $.ajax({
        url:'php/mainFact.php?op=4',
        data:'inm_id='+inm_id,
        dataType:'JSON',
        type:'POST',
        success:function(data){},
        error:function(error){
            console.error('ERROR:',error);
        }
    }).done(function(data){
       console.log('Datos de detalle:',data);
        $.each(data,function(ind,val){
            $('#idProd').val(val.id_producto);
            $('#idInm').val(val.inm_id);
            $('#codBarras').val(val.cve_producto);
            $('#nomProd').val(val.descripcion);
            $('#numFact').val(val.inm_num_factura);
            $('#cantidad').val(val.inm_cantidad);
            $('#precUnitCompra').val(val.inm_precio_compra);
            $('#precUnitVenta').val(val.inm_precio_venta);
            if(val.id_facturacion==1){
                $('#tpFact').prop('checked',true);
                $('#tpNoFact').prop('checked',false);
            }
            if(val.id_facturacion==2){
                $('#tpNoFact').prop('checked',true);
                $('#tpFact').prop('checked',false);
            }

            //$('#tipoFact').val(val.id_facturacion);
            
            
        });
    }).fail(function(error){
        console.error('FAIL:',error);
    });





    $('#modalDetalle').modal('show');
}




function alert_mensaje(lugar,tipo,cadena){
    lugar.append('<div id="alert_msj" class="alert '+tipo+'" >'+cadena+'</div>');
}
$(document).ready(function(){

    //popula cidades a partir de um dado estado
    $("select.ajax-state").change(function() {
        var state = $("select.ajax-state").val();
        $("select.ajax-city").html('<option>Aguarde...</option>');

        if ((state > 0) == false) {
            $("select.ajax-city").html('<option value="">Selecione</option>');
            return;
        }

        $.ajax({
            url: baseUrl + "/ajax/obter-cidades/",
            data: {"estadoID" : state },
            success: function(json) {
                var html = '<option value="">Selecione</option>';
                for(var i = 0; i < json.length; i++) {
                    html += '<option value="' + json[i].id + '">' + json[i].name + '</option>';
                }
                $("select.ajax-city").html(html);
            }
        });
    });
   
});
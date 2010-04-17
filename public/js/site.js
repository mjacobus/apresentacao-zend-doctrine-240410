$(document).ready(function(){

    //popula cidades a partir de um dado estado
    $("select.ajax.state").change(function(){
        var state = $("select.ajax.state").val();
        if ((state > 0) == false)
            return;
        
        $("select.ajax.city").ajaxAddOption(baseUrl + "/ajax/get-cityes" ,
            {"stateID" : state },
            false,
            sortoptions11
        );
    });
    
    

    
});
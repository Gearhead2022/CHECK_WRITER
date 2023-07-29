$(".productForm").on("change keypress keyup blur", "#ucost,#uprice", function(){
   var markup = $("#uprice").val() - $("#ucost").val();	
   $("#mrk").val(markup);
});



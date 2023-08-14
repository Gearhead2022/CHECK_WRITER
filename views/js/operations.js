$('.operationTable').DataTable({
    "ajax": "ajax/operation.ajax.php", 
    "deferRender": true,
    "retrieve": true,
    "processing": true
  });

  $(".slcType").on("change", function(){
    var select1 = document.getElementById('type1');
    var selectedValue = select1.value;
    var showGrossing =  document.getElementById('grossin');
    var showOutgoing =  document.getElementById('outgoing');
    if(selectedValue === "grossin"){
        showGrossing.hidden = false;
        showOutgoing.hidden = true;
        $("#addBeginning").attr("name", "addGrossin");
    }else if(selectedValue === "outgoing"){
        showGrossing.hidden = true;
        showOutgoing.hidden = false;
        $("#addBeginning").attr("name", "addOutgoing");
    }  
    
  })

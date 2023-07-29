$("#btn_mode").on("click", function(){
    document.body.classList.remove(
        'bg-theme7'
      );
      document.body.classList.add(
        'bg-theme9',
      );
  })
  
  $("#chk_btn").on("click", function(){
    if(document.getElementById("chk_btn").checked){
      var chk = "on";
      
  }else{
      var chk = "off";
     
  }
  $.ajax({
    method: "POST",
    url: "ajax/switch.ajax.php",
    data: {chk: chk}
  })
  .done(function( msg ) {
    window.location.href = 'index.php';   
  
  });

  return false;

  })
<style>
  #lb{
    position: relative;
  }
  #lb input[type="checkbox"]{
    opacity: 0;
    display: none;
  }
  .check{
    display: block;
    width: 40px;
    height: 20px;
    border: 1px solid #222;
    border-radius: 40px;
    transition: 0.5s;
  }
  #lb input[type="checkbox"]:checked  ~ .check{
    border: 1px solid #fff;
  }
  .check:before{
    content: '';
    position: absolute;
    width: 18px;
    height: 18px;
    border: 2x solid #000;
    box-sizing: border-box;
    background: #97d893;
    border-radius: 50%;
    box-shadow: inset 0 0 0 1px #222;
    transition: 0.5s;
  }
  #lb input[type="checkbox"]:checked ~ .check:before{
    box-shadow: inset 0 0 0 1px #fff;
    background: #fff;
    transform: translateX(20px);

  }

</style>

<?php 

  $mode = $_SESSION['mode'];
  if($mode=="dark"){
    $switch = "checked";
  }else{
    $switch = "";
  }
 
  

?>
<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void();">
       <i class="icon-menu menu-icon"></i>
     </a>
    </li>
  </ul>
     
  <ul class="navbar-nav align-items-center">
        <label id="lb">
          <input type="checkbox" name="chk" <?php echo $switch; ?>  id="chk_btn" >
          <span class="check"></span>
        </label>
  </ul>
</nav>
</header>

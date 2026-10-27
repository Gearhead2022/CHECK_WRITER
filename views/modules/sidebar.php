<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
 <div class="brand-logo">
   <a href="home">
     <img src="views/img/JGC LOGO.png" class="logo-icon" alt="logo icon">
   </a>
 </div>
 <ul class="sidebar-menu">   
  <li class="sidebar-header">GENERAL INFO</li>


      <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" ) {?> 
          <li>
            <a href="checkWriter" class="waves-effect">
              <i class="fa fa-medkit"></i> <span>Check Writer</span></i>
            </a>
        </li>
      <?php }?>
    
      <li>
      <a id="logout" class="waves-effect">
          <i class="fa fa-sign-out"></i> <span>Logout</span></i>
        </a>
      </li>
  </ul>
</div>


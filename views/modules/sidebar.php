<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
 <div class="brand-logo">
   <a href="home">
     <img src="views/img/JGC LOGO.png" class="logo-icon" alt="logo icon">
   </a>
 </div>

 <ul class="sidebar-menu">   
  <li class="sidebar-header">GENERAL INFO</li>
  <?php if($_SESSION['type']=="admin" ||  $_SESSION['type']=="hr_admin" ||  $_SESSION['type']=="hr_user") {?>
  <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="fa fa-ban"></i> <span>Blacklisted</span><i class="fa fa-angle-left pull-right"></i>
        </a>
		<ul class="sidebar-submenu">
		  <li><a href="blacklist"><i class="zmdi zmdi-dot-circle-alt"></i>Accounts</a></li>
		</ul>
      </li>
    
  <?php } ?>
      <?php if($_SESSION['type']=="admin" ||  $_SESSION['type']=="hr_admin" ||  $_SESSION['type']=="hr_user") {?>
      <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="zmdi zmdi-collection-plus"></i> <span>ID Application Form</span><i class="fa fa-angle-left pull-right"></i>
        </a>
		<ul class="sidebar-submenu">
		  <li><a href="clients"><i class="zmdi zmdi-dot-circle-alt"></i>EMB</a></li>
		</ul>
    <ul class="sidebar-submenu">
		  <li><a href="fch"><i class="zmdi zmdi-dot-circle-alt"></i>FCH</a></li>
		</ul>
    <ul class="sidebar-submenu">
		  <li><a href="pspmi"><i class="zmdi zmdi-dot-circle-alt"></i>PSPMI</a></li>
		</ul>
    <ul class="sidebar-submenu">
		  <li><a href="rlc"><i class="zmdi zmdi-dot-circle-alt"></i>RLC</a></li>
		</ul>
      </li>
      <?php }?>
      <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="wp_admin" || $_SESSION['type']=="wp_user" 
       || $_SESSION['type']=="backup" || $_SESSION['type']=="wp_approve" || $_SESSION['type']=="wp_check") {?> 
      <li>
       
	
		  <li>
        <a href="workingpermit"  class="waves-effect">
          <i class="fa fa-file"></i><span> Working Permit </span>
        </a>
      </li>
		  <li>
        <a href="request"  class="waves-effect">
          <i class="fa fa-files-o"></i><span> Request</span>
        </a>
      </li>
      </li>
      <?php }?>
      <?php if($_SESSION['type']=="dp_admin") {?> 
      <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="zmdi zmdi-file"></i> <span>Request</span><i class="fa fa-angle-left pull-right"></i>
        </a>
		<ul class="sidebar-submenu">
		  <li><a href="workingpermit"><i class="zmdi zmdi-dot-circle-alt"></i>Working Permit</a></li>
		</ul>
      </li>
      <?php }?>
      <?php if($_SESSION['type']=="backup_user" || $_SESSION['type']=="backup_admin" ||  $_SESSION['type']=="admin"  ) {?> 
        <li>
          <a href="backups"  class="waves-effect">
            <i class="fa fa-hdd-o"></i><span>Backup</span></i>
          </a>
        </li>
        <?php }?>


        <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" ) {?> 
      <li>
      <a href="fullypaid" class="waves-effect">
          <i class="fa fa-money"></i> <span>Fully Paid</span></i>
        </a>
      </li>
      <?php }?>
      <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" ) {?> 
      <li>
      <a href="checklist" class="waves-effect">
          <i class="fa fa-list-alt "></i> <span>Daily Checklist</span></i>
        </a>
      </li>
      <?php }?>

      <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="pastdue_user" ) {?> 
      <li>
      <a href="pastdue" class="waves-effect">
          <i class="fa fa-hourglass "></i> <span>Past Due</span></i>
        </a>
      </li>
      <?php }?>


      <?php if($_SESSION['type']=="admin") {?> 
      <li>
      <a href="accounts" class="waves-effect">
          <i class="fa fa-user-plus"></i> <span>Create Account</span></i>
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


<?php
	$adminId=$_SESSION['aid'];
  $logo=getProjectLogo();
	$str=str_replace('/','',$_SERVER['PHP_SELF']);
	$sqlqry="select * from admin where id='$adminId'";
	$fetch=mysqli_fetch_array(mysqli_query($con,$sqlqry));

?>
<header id="page-topbar" style="display:none" >
<div class="navbar-header">
<div class="d-flex">
   <!-- LOGO -->
   <div class="navbar-brand-box">
       <a href="dashboard.php" class="logo logo-dark">

           <span class="logo-sm">
               <img src="patientZoneCMSAdmin/src/assets/img/<?php echo $logo ?>" alt="" height="22">
           </span>
           <span class="logo-lg">
               <img src="patientZoneCMSAdmin/src/assets/img/<?php echo $logo ?>" alt="" height="17">
           </span>
       </a>

   </div>
   <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
       <i class="fa fa-fw fa-bars"></i>
   </button>
   <!-- App Search-->
</div>
<div class="d-flex">
   <div class="dropdown d-inline-block">
       <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <img class="rounded-circle header-profile-user" src="assets/images/user.png"
               alt="Header Avatar">
           <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?php echo $fetch['username'] ?></span>
           <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
       </button>
       <div class="dropdown-menu dropdown-menu-end">
           <!-- item-->
           <a class="dropdown-item d-block" href="settings.php"><span class="badge bg-success float-end">11</span><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Settings</span></a>
           <a class="dropdown-item" href="lock-screen.php"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i> <span key="t-lock-screen">Lock screen</span></a>
           <div class="dropdown-divider"></div>
           <a class="dropdown-item text-danger" href="logout"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
       </div>
   </div>

</div>
</div>
</header>

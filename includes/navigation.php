 <?php
 session_start();
 global $active_nav;
 $id=$_SESSION['google_data']['id'];
 $name=$_SESSION['google_data']['name'];
 $email=$_SESSION['google_data']['email'];
 $picture=$_SESSION['google_data']['picture'];
 $to_uid=$id;
 $gUser=new Users();
 $no_unseen_requests=$gUser->no_unseen_requests($to_uid);
 ?>
 <ul id="slide-out" class="side-nav fixed">
  <div class="hide-on-large-only closebuttonnav">
    <a href="#" class="close-button-nav"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a>
  </div>  
  <li>
    <div class="userView">
     <img class="nav-background" src="images/yellowbg.png">

     <div class="center-align"><a href="editdetails.php"><img class="circle nav-profile-pic" src="<?php echo $picture;?>"></a></div>
     <a href="editdetails.php" class="details"><span class="white-text name"><span class="detailsname truncate"><?php echo ucwords($name);?></span><br><br><span class="detailsemail"><?php echo $email;?></span> </span></a>

   </div>
 </li>
 <li class="<?php if($active_nav=='editdetails') echo 'active ';?>waves-effect"><a href="editdetails.php"><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp;Edit My Details</a></li>
 <li class="<?php if($active_nav=='requests') echo 'active ';?>waves-effect"><a href="requests.php"><i class="fa fa-envelope" aria-hidden="true"></i> &nbsp;Requests <?php if($no_unseen_requests>0){ echo "<span class='new badge'>".$no_unseen_requests."</span>";}?></a></li>
 <li class="<?php if($active_nav=='samedate') echo 'active ';?>waves-effect"><a href="samedate.php"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;Same Date Travellers</a></li>
 <li class="<?php if($active_nav=='sameflight') echo 'active ';?>waves-effect"><a href="sameflight.php"><i class="fa fa-plane" aria-hidden="true"></i>
   &nbsp;Same Flight/Train</a></li>
   <li class="<?php if($active_nav=='showall') echo 'active ';?>waves-effect"><a href="showall.php"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;Show All</a></li>
   <li><div class="divider"></div></li>
   <li class="<?php if($active_nav=='logout') echo 'active ';?>waves-effect"><a href="logout.php" onclick="return confirm('Are you sure you want to logout?')"><i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp;Logout</a></li>
 </ul>
 <div class="hide-on-large-only">
   <nav>
    <div class="nav-wrapper">
      <a href="#" class="brand-logo right"> <img class="navlogo-mobile" src="images/logo_black_org.png"></a>
      <ul id="nav-mobile" class="">
        <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
      </ul>
    </div>
  </nav>

</div>

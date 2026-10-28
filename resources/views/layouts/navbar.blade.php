 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

     <!-- Sidebar Toggle (Topbar) -->
     <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
         <i class="fa fa-bars"></i>
     </button>

     <!-- Topbar Navbar -->
     <ul class="navbar-nav ml-auto">

         <div class="topbar-divider d-none d-sm-block"></div>

         <!-- Nav Item - User Information -->
         <li class="nav-item dropdown no-arrow">
             <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false">
                 <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                     {{ auth()->user()->name }}
                 </span>
                 <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
             </a>
             <!-- Dropdown - User Information -->
             <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                 <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                     <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                     Logout
                 </a>
             </div>
         </li>

     </ul>

 </nav>

 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">

     <div class="modal-dialog" role="document">
         <div class="modal-content">

             <div class="modal-header">
                 <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                     @csrf
                 </form>
                 <h5 class="modal-title">Ready to Leave?</h5>
                 <button class="close" type="button" data-dismiss="modal">
                     <span>×</span>
                 </button>
             </div>

             <div class="modal-body">
                 Pilih "Logout" jika ingin keluar dari sistem.
             </div>

             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">
                     Cancel
                 </button>

                 <button class="btn btn-primary"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                     Logout
                 </button>
             </div>

         </div>
     </div>
 </div>

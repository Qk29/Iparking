<div id="sidebar" class="sidebar sidebar-fixed expandable sidebar-light">
          <div class="sidebar-inner">

            <div class="ace-scroll flex-grow-1" data-ace-scroll="{}">

              <div class="sidebar-section my-2">
                <!-- the shortcut buttons -->
                <div class="sidebar-section-item fadeable-left">
                  <div class="fadeinable sidebar-shortcuts-mini">
                    <!-- show this small buttons when collapsed -->
                    <span class="btn btn-success p-0 opacity-1"></span>
                    <span class="btn btn-info p-0 opacity-1"></span>
                    <span class="btn btn-orange p-0 opacity-1"></span>
                    <span class="btn btn-danger p-0 opacity-1"></span>
                  </div>

                  <div class="fadeable">
                    <!-- show this small buttons when not collapsed -->
                    <div class="sub-arrow"></div>
                    <div>
                      <button class="btn px-25 py-2 text-95 btn-success opacity-1">
                        <i class="fa fa-signal f-n-hover"></i>
                      </button>

                      <button class="btn px-25 py-2 text-95 btn-info opacity-1">
                        <i class="fa fa-edit f-n-hover"></i>
                      </button>

                      <button class="btn px-25 py-2 text-95 btn-orange opacity-1">
                        <i class="fa fa-users f-n-hover"></i>
                      </button>

                      <button class="btn px-25 py-2 text-95 btn-danger opacity-1">
                        <i class="fa fa-cogs f-n-hover"></i>
                      </button>
                    </div>
                  </div>
                </div>


                <!-- the search box -->
                <div class="sidebar-section-item">
                  <i class="fadeinable fa fa-search text-info-m1 mr-n1"></i>

                  <div class="fadeable d-inline-flex align-items-center ml-3 ml-lg-0">
                    <i class="fa fa-search mr-n3 text-info-m1"></i>
                    <input type="text" class="sidebar-search-input pl-4 pr-3 mr-n2" maxlength="60" placeholder="Search ..." aria-label="Search" />
                    <a href="javascript:void(0)" class="ml-n25 px-2 py-1 radius-round bgc-h-secondary-l2 mb-2px">
                      <i class="fa fa-microphone px-3px text-dark-tp5"></i>
                    </a>
                  </div>
                </div>
              </div>

              <ul class="nav has-active-border active-on-right">


                <li class="nav-item-caption">
                  <span class="fadeable pl-3">MAIN</span>
                  <span class="fadeinable mt-n2 text-125">&hellip;</span>
                </li>


                <li class="nav-item active">

                  <a href="index.php?page=event-card" class="nav-link">
                    <i class="nav-icon fa fa-tachometer-alt"></i>
                    <span class="nav-text fadeable">
               	  <span>Bàn làm việc</span>
                    </span>


                  </a>

                  <b class="sub-arrow"></b>

                </li>


                <li class="nav-item">

                  <a href="javascript:void(0)" class="nav-link dropdown-toggle collapsed" id="menu-bao-cao">
                    <i class="nav-icon fa fa-chart-line"></i>
                    <span class="nav-text fadeable">
               	  <span>Báo cáo</span>
                    </span>
                    <b class="caret fa fa-angle-left rt-n90"></b>
                  </a>

                  <div class="hideable submenu collapse">
                    <ul class="submenu-inner">

                     <li class="nav-item">
                      <a href="javascript:void(0)" class="nav-link dropdown-toggle collapsed" data-toggle="collapse" data-target="#submenu-xe-trong-bai" aria-expanded="false">
                        <span class="nav-text">
                          <span>Xe trong bãi</span>
                        </span>
                        <b class="caret fa fa-angle-left rt-n90"></b>
                      </a>

                      <div class="submenu collapse" id="submenu-xe-trong-bai">
                        <ul class="submenu-inner">

                          <li class="nav-item">
                            <a href="index.php?page=car-in" class="nav-link">
                              <span class="nav-text">
                                <span>Xe trong bãi hiện tại</span>
                              </span>
                            </a>
                          </li>

                          <li class="nav-item">
                            <a href="html/chi-tiet-xe-trong-bai.html" class="nav-link">
                              <span class="nav-text">
                                <span>Chi tiết xe trong bãi</span>
                              </span>
                            </a>
                          </li>

                        </ul>
                      </div>
                    </li>

                      <li class="nav-item">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle collapsed"  data-toggle="collapse" data-target="#submenu-xe-vao-ra" aria-expanded="false">
                          <span class="nav-text">
               				  <span>Xe vào/ra</span>
                          <b class="caret fa fa-angle-left rt-n90"></b>
                        </a>
                        <div class="submenu collapse" id="submenu-xe-vao-ra">
                        <ul class="submenu-inner">

                          <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link">
                              <span class="nav-text">
                                <span>Xe ra khỏi bãi</span>
                              </span>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link">
                              <span class="nav-text">
                                <span>Xe vào bãi</span>
                              </span>
                            </a>
                          </li>
                        </ul>
                        </div>
                      </li>

                      <li class="nav-item">
                        <a href="html/dashboard-4.html" class="nav-link">
                          <span class="nav-text">
               				  <span>Thu tiền thẻ lượt</span>
                          </span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="html/horizontal.html" class="nav-link">
                          <span class="nav-text">
               				  <span>Báo cáo lượt xe ra vào miễn phí</span>
                          </span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="html/two-menus-1.html" class="nav-link">
                          <span class="nav-text">
               				  <span>Xử lí thẻ</span>
                          </span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="html/landing-page-1.html" class="nav-link">
                          <span class="nav-text">
               				  <span>Sự kiện cảnh báo</span>
                          </span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="html/landing-page-2.html" class="nav-link">
                          <span class="nav-text">
               				  <span>Thẻ theo căn hộ</span>
                          </span>
                        </a>
                      </li>
                    </ul>
                  </div>

                  <b class="sub-arrow"></b>

                </li>


                <li class="nav-item">

                  <a href="javascript:void(0)" class="nav-link dropdown-toggle collapsed" id="menu-bieu-do">
                    <i class="nav-icon fa fa-chart-pie"></i>
                    <span class="nav-text fadeable">
               	  <span>Biểu đồ</span>
                    </span>

                    <b class="caret fa fa-angle-left rt-n90"></b>

                    <!-- or you can use custom icons. first add `d-style` to 'A' -->
                    <!--
               	 	<b class="caret d-n-collapsed fa fa-minus text-80"></b>
               	 	<b class="caret d-collapsed fa fa-plus text-80"></b>
               	 -->
                  </a>

                  <div class="hideable submenu collapse">
                    <ul class="submenu-inner">
                      


                      <li class="nav-item">

                        <a href="html/icons.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Icons</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/typography.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Typography</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">
                        <a href="html/charts.html" class="nav-link">
                          <span class="nav-text">
               				  <span>Charts</span>
                          </span>
                        </a>


                      </li>

                      <li class="nav-item">
                        <a href="html/treeview.html" class="nav-link">
                          <span class="nav-text">
               				  <span>Treeview</span>
                          </span>
                        </a>
                      </li>
                    </ul>
                  </div>

                  <b class="sub-arrow"></b>

                </li>


                <li class="nav-item">

                  <a href="javascript:void(0)" class="nav-link dropdown-toggle collapsed" id="menu-quan-ly-the">
                    <i class="nav-icon fa fa-id-card"></i>
                    <span class="nav-text fadeable">
               	  <span>Quản lí thẻ</span>
                    </span>

                    <b class="caret fa fa-angle-left rt-n90"></b>

                    <!-- or you can use custom icons. first add `d-style` to 'A' -->
                    <!--
               	 	<b class="caret d-n-collapsed fa fa-minus text-80"></b>
               	 	<b class="caret d-collapsed fa fa-plus text-80"></b>
               	 -->
                  </a>

                  <div class="hideable submenu collapse">
                    <ul class="submenu-inner">

                      <li class="nav-item">
                        <a href="html/table-basic.html" class="nav-link">
                          <span class="nav-text">
               				  <span>Basic Tables</span>
                          </span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="html/table-datatables.html" class="nav-link">
                          <span class="nav-text">
               				  <span>DataTables</span>
                          </span>
                        </a>
                      </li>

                      <li class="nav-item">

                        <a href="html/table-bootstrap.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Bootstrap Table</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/table-jqgrid.html" class="nav-link">

                          <span class="nav-text">
               				  <span>jqGrid</span>
                          </span>


                        </a>


                      </li>

                    </ul>
                  </div>

                  <b class="sub-arrow"></b>

                </li>


                <li class="nav-item">

                  <a href="javascript:void(0)" class="nav-link dropdown-toggle collapsed" id="menu-quan-ly-khach-hang">
                    <i class="nav-icon fa fa-users"></i>
                    <span class="nav-text fadeable">
               	  <span>Quản lý khách hàng</span>
                    </span>

                    <b class="caret fa fa-angle-left rt-n90"></b>

                    <!-- or you can use custom icons. first add `d-style` to 'A' -->
                    <!--
               	 	<b class="caret d-n-collapsed fa fa-minus text-80"></b>
               	 	<b class="caret d-collapsed fa fa-plus text-80"></b>
               	 -->
                  </a>

                  <div class="hideable submenu collapse">
                    <ul class="submenu-inner">

                      <li class="nav-item">

                        <a href="html/form-basic.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Basic Elements</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/form-more.html" class="nav-link">

                          <span class="nav-text">
               				  <span>More Elements</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/form-wizard.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Wizard &amp; Validation</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/form-upload.html" class="nav-link">

                          <span class="nav-text">
               				  <span>File Upload</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/form-wysiwyg.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Wysiwyg &amp; Markdown</span>
                          </span>


                        </a>


                      </li>

                    </ul>
                  </div>

                  <b class="sub-arrow"></b>

                </li>


                <li class="nav-item">
                  <a href="javascript:void(0)" class="nav-link dropdown-toggle collapsed" id="menu-danh-muc">
                    <i class="nav-icon far fa fa-folder-open"></i>
                    <span class="nav-text fadeable">
               	  <span>Danh Mục</span>
                    </span>
                    <b class="caret fa fa-angle-left rt-n90"></b>
                  </a>

                  <div class="hideable submenu collapse">
                    <ul class="submenu-inner">

                      <li class="nav-item">
                        <a href="index.php?page=card-category" class="nav-link">
                          <span class="menu-text">
                            <i class="fas fa-caret-right mr-1 "></i>
               				  <span>Nhóm thẻ</span>
                          </span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="index.php?page=apartment-group" class="nav-link">
                          <span class="menu-text">
                            <i class="fas fa-caret-right mr-1 "></i>
               				  <span>Nhóm căn hộ</span>
                          </span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="index.php?page=customer-group" class="nav-link">
                          <span class="menu-text">
                          <i class="fas fa-caret-right mr-1 "></i>

               				    <span>Nhóm khách hàng</span>
                          </span>
                        </a>
                      </li>

                    </ul>
                  </div>
                </li>

                <li class="nav-item">
                  <a href="html/calendar.html" class="nav-link dropdown-toggle collapsed" id="menu-cai-dat-thiet-bi">
                    <i class="nav-icon far fa fa-desktop"></i>
                    <span class="nav-text fadeable">
               	  <span>Cài đặt thiết bị</span>
                  <b class="caret fa fa-angle-left rt-n90"></b>
                  </a>

                  <div class="hideable submenu collapse">
                    <ul class="submenu-inner">

                      <li class="nav-item">
                        <a href="index.php?page=gate" class="nav-link">
                          <span class="menu-text">
                            <i class="fas fa-caret-right mr-1 "></i>
               				  <span>Cổng</span>
                          </span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="index.php?page=computer" class="nav-link">
                          <span class="menu-text">
                            <i class="fas fa-caret-right mr-1 "></i>
               				  <span>Máy tính</span>
                          </span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="index.php?page=camera" class="nav-link">
                          <span class="menu-text">
                            <i class="fas fa-caret-right mr-1 "></i>
               				  <span>Cameras</span>
                          </span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="index.php?page=controller" class="nav-link">
                          <span class="menu-text">
                            <i class="fas fa-caret-right mr-1 "></i>
               				  <span>Bộ điều khiển</span>
                          </span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="index.php?page=card-category" class="nav-link">
                          <span class="menu-text">
                            <i class="fas fa-caret-right mr-1 "></i>
               				  <span>Làn vào/ra</span>
                          </span>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="index.php?page=led-display" class="nav-link">
                          <span class="menu-text">
                            <i class="fas fa-caret-right mr-1 "></i>
               				  <span>LED hiển thị</span>
                          </span>
                        </a>
                      </li>
                    </ul>
                  </div>
                      
                </li>


                <li class="nav-item">

                  <a href="#" class="nav-link dropdown-toggle collapsed" id="menu-he-thong">
                    <i class="nav-icon far fa fa-cog"></i>
                    <span class="nav-text fadeable">
               	  <span>Hệ thống</span>
                  <b class="caret fa fa-angle-left rt-n90"></b>
                    </span>
                  </a>
                  <div class="hideable submenu collapse">
                    <ul class="submenu-inner">

                      <li class="nav-item">
                        <a href="index.php?page=user-system" class="nav-link">
                          <span class="menu-text">
                            <i class="fas fa-caret-right mr-1 "></i>
               				      <span>Người dùng</span>
                          </span>
                        </a>
                      </li>


                      <li class="nav-item">
                        <a href="index.php?page=role-system" class="nav-link">
                          <span class="menu-text">
                            <i class="fas fa-caret-right mr-1 "></i>
               				      <span>Vai trò/ quyền hạn</span>
                          </span>
                        </a>
                      </li>


                      <li class="nav-item">
                        <a href="html/table-basic.html" class="nav-link">
                          <span class="menu-text">
                            <i class="fas fa-caret-right mr-1 "></i>
               				      <span>Danh mục hệ thống</span>
                          </span>
                        </a>
                      </li>


                      <li class="nav-item">
                        <a href="html/table-basic.html" class="nav-link">
                          <span class="menu-text">
                            <i class="fas fa-caret-right mr-1 "></i>
               				      <span>Tham số hệ thống</span>
                          </span>
                        </a>
                      </li>


                      <li class="nav-item">
                        <a href="html/table-basic.html" class="nav-link">
                          <span class="menu-text">
                            <i class="fas fa-caret-right mr-1 "></i>
               				      <span>Nhật ký hệ thống</span>
                          </span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>

              </ul>

            </div><!-- /.sidebar scroll -->

          </div>
        </div>

        <!-- Js -->


        
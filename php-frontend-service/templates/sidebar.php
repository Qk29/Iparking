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
                    <a href="#" class="ml-n25 px-2 py-1 radius-round bgc-h-secondary-l2 mb-2px">
                      <i class="fa fa-microphone px-3px text-dark-tp5"></i>
                    </a>
                  </div>
                </div>
              </div>

              <ul class="nav has-active-border active-on-right">


                <li class="nav-item-caption">
                  <span class="fadeable pl-3">MAIN</span>
                  <span class="fadeinable mt-n2 text-125">&hellip;</span>
                  <!--
               			OR something like the following (with `.hideable` text)
               		-->
                  <!--
               			<div class="hideable">
               				<span class="pl-3">MAIN</span>
               			</div>
               			<span class="fadeinable mt-n2 text-125">&hellip;</span>
               		-->
                </li>


                <li class="nav-item active">

                  <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-tachometer-alt"></i>
                    <span class="nav-text fadeable">
               	  <span>Bàn làm việc</span>
                    </span>


                  </a>

                  <b class="sub-arrow"></b>

                </li>


                <li class="nav-item">

                  <a href="#" class="nav-link dropdown-toggle collapsed">
                    <i class="nav-icon fa fa-cube"></i>
                    <span class="nav-text fadeable">
               	  <span>Báo cáo</span>
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

                        <a href="html/dashboard-2.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Dashboard 2</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/dashboard-3.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Dashboard 3</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/dashboard-4.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Dashboard 4</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/horizontal.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Horizontal Menu</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/two-menus-1.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Two Menus</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/landing-page-1.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Landing Page 1</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/landing-page-2.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Landing Page 2</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/coming-soon.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Coming Soon</span>
                          </span>


                        </a>


                      </li>

                    </ul>
                  </div>

                  <b class="sub-arrow"></b>

                </li>


                <li class="nav-item">

                  <a href="#" class="nav-link dropdown-toggle collapsed">
                    <i class="nav-icon fa fa-desktop"></i>
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

                        <a href="html/buttons.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Buttons</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/button-groups.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Button Groups</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/alerts.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Alerts</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/modals.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Modals</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/asides.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Asides</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/tabs.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Tabs</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/accordions.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Accordions</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/tooltips.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Tooltips &amp; Popovers</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/badges.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Badges</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/pagination.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Pagination</span>
                          </span>


                        </a>


                      </li>


                      <li class="nav-item">

                        <a href="html/dropdowns.html" class="nav-link">

                          <span class="nav-text">
               				  <span>Dropdowns</span>
                          </span>


                        </a>


                      </li>


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


                      <li class="nav-item">

                        <a href="#" class="nav-link dropdown-toggle collapsed">

                          <span class="nav-text">
               				  <span>Nested Links</span>
                          </span>

                          <b class="caret fa fa-angle-left rt-n90"></b>

                          <!-- or you can use custom icons. first add `d-style` to 'A' -->
                          <!--
               				 	<b class="caret d-n-collapsed fa fa-minus text-80"></b>
               				 	<b class="caret d-collapsed fa fa-plus text-80"></b>
               				 -->
                        </a>

                        <div class=" submenu collapse">
                          <ul class="submenu-inner">

                            <li class="nav-item">

                              <a href="#" class="nav-link dropdown-toggle collapsed">
                                <i class="nav-icon fa fa-caret-right text-blue-l2 mr-2"></i>
                                <span class="nav-text">
               							  <span>Third Level Menu</span>
                                </span>

                                <b class="caret fa fa-angle-left rt-n90"></b>

                                <!-- or you can use custom icons. first add `d-style` to 'A' -->
                                <!--
               							 	<b class="caret d-n-collapsed fa fa-minus text-80"></b>
               							 	<b class="caret d-collapsed fa fa-plus text-80"></b>
               							 -->
                              </a>

                              <div class=" submenu collapse">
                                <ul class="submenu-inner">

                                  <li class="nav-item">

                                    <a href="#" class="nav-link dropdown-toggle collapsed">
                                      <i class="nav-icon fa fa-leaf text-success-l2 text-90 mr-2"></i>
                                      <span class="nav-text">
               										  <span>Fourth Level</span>
                                      </span>

                                      <b class="caret fa fa-angle-left rt-n90"></b>

                                      <!-- or you can use custom icons. first add `d-style` to 'A' -->
                                      <!--
               										 	<b class="caret d-n-collapsed fa fa-minus text-80"></b>
               										 	<b class="caret d-collapsed fa fa-plus text-80"></b>
               										 -->
                                    </a>

                                    <div class=" submenu collapse">
                                      <ul class="submenu-inner">

                                        <li class="nav-item">

                                          <a href="#" class="nav-link">
                                            <i class="nav-icon fa fa-stop text-warning-l1 text-80 mx-2"></i>
                                            <span class="nav-text">
               													  <span>5th Level</span>
                                            </span>


                                          </a>


                                        </li>


                                        <li class="nav-item">

                                          <a href="#" class="nav-link">
                                            <i class="nav-icon fa fa-stop text-warning-l1 text-80 mx-2"></i>
                                            <span class="nav-text">
               													  <span>5th Level</span>
                                            </span>


                                          </a>


                                        </li>

                                      </ul>
                                    </div>

                                    <b class="sub-arrow"></b>

                                  </li>

                                </ul>
                              </div>

                              <b class="sub-arrow"></b>

                            </li>

                          </ul>
                        </div>

                        <b class="sub-arrow"></b>

                      </li>

                    </ul>
                  </div>

                  <b class="sub-arrow"></b>

                </li>


                <li class="nav-item">

                  <a href="#" class="nav-link dropdown-toggle collapsed">
                    <i class="nav-icon fa fa-table"></i>
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

                  <a href="#" class="nav-link dropdown-toggle collapsed">
                    <i class="nav-icon fa fa-edit"></i>
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

                  <a href="html/cards.html" class="nav-link">
                    <i class="nav-icon far fa-window-restore"></i>
                    <span class="nav-text fadeable">
               	  <span>Danh Mục</span>
                    </span>


                  </a>

                  <b class="sub-arrow"></b>

                </li>


                <li class="nav-item">

                  <a href="html/calendar.html" class="nav-link">
                    <i class="nav-icon far fa-calendar-alt"></i>
                    <span class="nav-text fadeable">
               	  <span>Cài đặt thiết bị</span>
                  </a>

                  <b class="sub-arrow"></b>

                </li>


                <li class="nav-item">

                  <a href="html/gallery.html" class="nav-link">
                    <i class="nav-icon far fa-image"></i>
                    <span class="nav-text fadeable">
               	  <span>Hệ thống</span>
                    </span>


                  </a>

                  <b class="sub-arrow"></b>

                </li>

              </ul>

            </div><!-- /.sidebar scroll -->


            

          </div>
        </div>

        
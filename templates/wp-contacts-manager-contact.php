<?php
wp_enqueue_style('admin-style-css'); 
?>

<div class="main-container-init">

    <div class="col-init-12">
        <div class="wp-contacts-manager-preloader">
            <span class="wp-contacts-manager-preloader-custom-gif"></span>
        </div>
        <div class="wp-contacts-manager-container-title"><h2><?php esc_html_e('List of Contacts', $this->text_domain); ?></h2></div>
    </div>
    <div ng-app="ajaxExample" ng-cloak class="content-area">
        <div ng-controller="mainController">
            <div class="col-init-12">
                <div class="form_wrapper create-contact" style="display: none;">
                    <div class="form_container">
                        <div class="title_container">
                            <h2><?php esc_html_e('Contact Details', $this->text_domain); ?></h2>
                            <h3 id="form_msg"></h3>
                            <a class="close" ng-click="close_contact_form()"></a>
                        </div>
                        <form method="POST" id="wp-contacts-manager-contact" name="form">
                            <div class="row clearfix">
                                <div class="col_thrid">
                                    <label><?php esc_attr_e('Name', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                                        <input placeholder="<?php esc_attr_e('Name', $this->text_domain); ?>"  ng-model="newName" type="text" required="required" id="newName"/>
                                    </div>
                                </div>
			                               <div class="col_thrid">
                                    <label><?php esc_attr_e('Last Name', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                                        <input placeholder="<?php esc_attr_e('Last Name', $this->text_domain); ?>"  ng-model="newLastname" type="text" required="required" id="newLastname" />
                                    </div>
                                </div>					
                                 <div class="col_thrid">
                                    <label><?php esc_attr_e('Personal Email', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
                                        <input type="email" ng-model="newEmail" placeholder="<?php esc_attr_e('name@gmail.com', $this->text_domain); ?>" required="required" />
                                   </div>
                                </div>                                
                            </div>
                            <div class="row clearfix">
							    <div class="col_thrid">
                                    <label><?php esc_attr_e('Personal Phone', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-phone"></i></span>
                                        <input placeholder="<?php esc_attr_e('P.Phone', $this->text_domain); ?>" ng-model="newPhone"  type="text" id="newPhone"/>
                                    </div>
                                </div>
                               <div class="col_thrid">
                                    <label><?php esc_attr_e('Company', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-industry"></i></span>
                                        <input placeholder="<?php esc_attr_e('Company', $this->text_domain); ?>"  ng-model="newCompany" type="text" id="newCompany" />
                                    </div>
                                </div>
                                <div class="col_thrid">
                                    <label><?php esc_attr_e('Job Title', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user-plus"></i></span>
                                        <input placeholder="<?php esc_attr_e('Job Title', $this->text_domain); ?>" ng-model="newJob"  type="text" id="newJob"/>
                                    </div>
                                </div>
                            </div> 
							
                            <div class="row clearfix">
							    <div class="col_thrid">
                                    <label><?php esc_attr_e('Email', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
                                        <input placeholder="<?php esc_attr_e('Email', $this->text_domain); ?>" ng-model="newTwo_Email"  type="text" id="newTwo_Email"/>
                                    </div>
                                </div>
                               <div class="col_thrid">
                                    <label><?php esc_attr_e('Phone', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-phone"></i></span>
                                        <input placeholder="<?php esc_attr_e('Phone', $this->text_domain); ?>"  ng-model="newTwo_Phone" type="text" id="newTwo_Phone" />
                                    </div>
                                </div>
                                <div class="col_thrid">
                                    <label><?php esc_attr_e('Web', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-globe"></i></span>
                                        <input placeholder="<?php esc_attr_e('Web', $this->text_domain); ?>" ng-model="newWeb"  type="text" id="newWeb"/>
                                    </div>
                                </div>
                            </div> 	
                           <div class="row clearfix">
							    <div class="col_one">
                                    <label><?php esc_attr_e('Address', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-address-card"></i></span>
                                        <input placeholder="<?php esc_attr_e('Address', $this->text_domain); ?>" ng-model="newTwo_Address"  type="text" id="newTwo_Address"/>
                                    </div>
                                </div>
                            </div>                            			
							<!-- <div class="row clearfix">
								<div>
                                     <label><?php esc_attr_e('Notes', $this->text_domain); ?></label>
                                    <div class="textarea_field"> <span><i aria-hidden="true" class="fa fa-file-text"></i></span>
                                        <textarea name="notes" cols="46" rows="2" placeholder="<?php esc_attr_e('Maximum 500 characters', $this->text_domain); ?>" ng-maxlength="500" ng-model="notes"></textarea>  <ngb-alert ng-show="form.notes.$error.maxlength">¡Error max. 500!</ngb-alert>
                                    </div>
                                </div>    
                            </div> -->

                            <input class="button" type="submit" ng-click="addPerson()" value="<?php esc_attr_e('Save', $this->text_domain); ?>" />
                        </form>
                    </div>
                </div>
                
                   <div class="form_wrapper edit-contact" style="display: none;">
                    <div class="form_container">
                        <div class="title_container">
                            <h2><?php esc_html_e('Edit Contact Details', $this->text_domain); ?></h2>
                            <h3 id="form_edit_msg"></h3>
                            <a class="close" ng-click="close_contact_form()"></a>
                        </div>
                        <form method="POST" name="form">
                            <div class="row clearfix">
                                <div class="col_thrid">
                                    <label><?php esc_attr_e('Name', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                                        <input placeholder="<?php esc_attr_e('Name', $this->text_domain); ?>"  ng-model="editnewName" type="text" required="required" id="editnewName"/>
                                    </div>
                                </div>
								<div class="col_thrid">
                                    <label><?php esc_attr_e('Last Name', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user"></i></span>
                                        <input placeholder="<?php esc_attr_e('Last Name', $this->text_domain); ?>"  ng-model="editnewLastname" type="text" required="required" id="editnewLastname"/>
                                    </div>
                                </div>
                                <div class="col_thrid">
                                    <label><?php esc_attr_e('Personal Email', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
                                        <input type="email" ng-model="editnewEmail" id="editnewEmail" placeholder="<?php esc_attr_e('name@gmail.com', $this->text_domain); ?>" />
                                   </div>
                                </div>
                            </div>
                            <div class="row clearfix">                                
                                <div class="col_thrid">
                                    <label><?php esc_attr_e('Personal Phone', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-phone"></i></span>
                                        <input placeholder="<?php esc_attr_e('P.Phone', $this->text_domain); ?>" ng-model="editnewPhone"  type="text" id="editnewPhone"/>
                                        <input  ng-model="editcontactID" id="editcontactID" type="hidden"/>
                                    </div>
                                </div>

                                <div class="col_thrid">
                                    <label><?php esc_attr_e('Company', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-industry"></i></span>
                                        <input placeholder="<?php esc_attr_e('Company', $this->text_domain); ?>"  ng-model="editnewCompany" type="text" id="editnewCompany"/>
                                    </div>
                                </div>  					
                                <div class="col_thrid">
                                    <label><?php esc_attr_e('Job Title', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-user-plus"></i></span>
                                        <input placeholder="<?php esc_attr_e('Job Title', $this->text_domain); ?>" ng-model="editnewJob"  type="text" id="editnewJob"/>
                                       </div>
                                </div>								
                            </div>
                            <div class="row clearfix">
							    <div class="col_thrid">
                                    <label><?php esc_attr_e('Email', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
                                        <input placeholder="<?php esc_attr_e('Email', $this->text_domain); ?>" ng-model="editnewTwo_Email"  type="text" id="editnewTwo_Email"/>
                                    </div>
                                </div>
                               <div class="col_thrid">
                                    <label><?php esc_attr_e('Phone', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-phone"></i></span>
                                        <input placeholder="<?php esc_attr_e('Phone', $this->text_domain); ?>"  ng-model="editnewTwo_Phone" type="text" id="editnewTwo_Phone" />
                                    </div>
                                </div>
                                <div class="col_thrid">
                                    <label><?php esc_attr_e('Web', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-globe"></i></span>
                                        <input placeholder="<?php esc_attr_e('Web', $this->text_domain); ?>" ng-model="editnewWeb"  type="text" id="editnewWeb"/>
                                    </div>
                                </div>
                            </div> 
                            <div class="row clearfix">
							    <div class="col_one">
                                    <label><?php esc_attr_e('Address', $this->text_domain); ?></label>
                                    <div class="input_field"> <span><i aria-hidden="true" class="fa fa-address-card"></i></span>
                                        <input placeholder="<?php esc_attr_e('Address', $this->text_domain); ?>" ng-model="editnewTwo_Address"  type="text" id="editnewTwo_Address"/>
                                    </div>
                                </div>
                            </div>                             							
							<!-- <div class="row clearfix">								
								<div>
                                    <label><?php esc_attr_e('Notes', $this->text_domain); ?></label>
                                    <div class="textarea_field"> <span><i aria-hidden="true" class="fa fa-file-text"></i></span>
                                        <textarea name="notes" cols="46" rows="2" placeholder="<?php esc_attr_e('Maximum 500 characters', $this->text_domain); ?>" ng-maxlength="500" ng-model="editnotes" id="editnotes"></textarea><ngb-alert ng-show="form.notes.$error.maxlength">¡Error max. 500!</ngb-alert>
                                    </div> 
                                </div>                                       
                            </div> -->
                            <input class="button" type="submit" ng-click="editPerson()" value="<?php esc_attr_e('Save', $this->text_domain); ?>" />
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-init-12">
                <div class="col-init-2 left"><?php esc_attr_e('Page Size', $this->text_domain); ?>:
                    <select ng-model="entryLimit" ng-init="entryLimit='100'" class="form-control">
                        <option ng-selected="true" value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="All"><?php esc_attr_e('All', $this->text_domain); ?></option>
                    </select>
                </div>
                
				
                <div class="col-init-3 right">
                    <a class="btn-init btn-info-init" ng-click="open_contact_form()"><i class="fa fa-plus"></i><?php esc_attr_e(' Create Contact', $this->text_domain); ?></a>
                </div>
            </div>
            <div class="col-init-12" ng-show="filteredItems > 0">
                <div class="overflow-table-area">
                <table>
                    <thead>
                        <tr>
							<th scope="col"><?php esc_attr_e('Name', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('name');"><i class="fa fa-sort"></i></a></th>
							<th scope="col"><?php esc_attr_e('Last Name', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('lastname');"><i class="fa fa-sort"></i></a></th>
							<th scope="col"><?php esc_attr_e('Personal Email', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('email');"><i class="fa fa-sort"></i></a></th>
                            <th scope="col"><?php esc_attr_e('Personal Phone', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('phone');"><i class="fa fa-sort"></i></a></th> 							
                            <th scope="col"><?php esc_attr_e('Web', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('web');"><i class="fa fa-sort"></i></a></th>
			                <th scope="col"><?php esc_attr_e('Company', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('company');"><i class="fa fa-sort"></i></a></th>
							<th scope="col"><?php esc_attr_e('Email', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('two_email');"><i class="fa fa-sort"></i></a></th>
                            <th scope="col"><?php esc_attr_e('Phone', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('two_phone');"><i class="fa fa-sort"></i></a></th>  						
                            <th scope="col"><?php esc_attr_e('Action', $this->text_domain); ?>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <tr class="tr1" ng-repeat="data in filtered = (people| filter:search | orderBy : predicate :reverse) | startFrom:(currentPage - 1) * entryLimit | limitTo:entryLimit">
                        	<td>{{data.name}}</td>
							<td>{{data.lastname}}</td>
							<td style="width: 50px">{{data.email}}</td>
                            <td>{{data.phone}}</td>
                            <td>{{data.web}}</td> 
							<td>{{data.company}}</td>
							<td>{{data.two_email}}</td>
                            <td>{{data.two_phone}}</td>						
							
                            <td><div class="delete-confirm" id="delete-confirm{{data.id}}"><strong><?php esc_attr_e('Delete', $this->text_domain);?></strong><p><?php esc_attr_e('Are you sure to want delete {{data.name}} ?', $this->text_domain); ?></p>
                                <div><span id="delete-confirm-yes{{data.id}}"><i class="fa fa-check"></i></span>&nbsp;&nbsp;<span id="delete-confirm-no{{data.id}}"><i class="fa fa-close"></i></span></div></div>
                                <i class="fa fa-pencil" ng-click="editContact_form(data.id)"></i>&nbsp;
                                <i class="fa fa-trash" ng-click="deleteConfirm(data.id)"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="total-item">
                    <span><?php esc_attr_e('Filtered {{ filtered.length}} of {{ totalItems}} total contacts', $this->text_domain);?></span>
                </div>
                </div>
            </div>
            <div class="col-init-12" ng-show="filteredItems == 0">
                 <div class="overflow-table-area">
                <table>
                    <tr>
                        <td colspan="5" style="text-align: center;"><?php esc_attr_e('No Contact found!', $this->text_domain); ?></td>
                    </tr>
                </table>
                <br>
                <br>
            </div>
            </div>
            <div class="col-init-12" ng-show="filteredItems > 0"> 
                <div pagination="" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimit" class="pagination" previous-text="&laquo;" next-text="&raquo;"></div>
            </div>
              <div class="col-init-12" ng-show="filteredItems > 0"  style="display: none;">
                <div class="overflow-table-area">
                <table id="contacts-list-manager">
                    <thead>
                        <tr>
							<th scope="col"><?php esc_attr_e('Name', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('name');"><i class="fa fa-sort"></i></a></th>
                            <th scope="col"><?php esc_attr_e('Last Name', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('lastname');"><i class="fa fa-sort"></i></a></th>
                            <th scope="col"><?php esc_attr_e('Personal Email', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('email');"><i class="fa fa-sort"></i></a></th>
                            <th scope="col"><?php esc_attr_e('Personal Phone', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('phone');"><i class="fa fa-sort"></i></a></th>
                            <th scope="col"><?php esc_attr_e('Company', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('company');"><i class="fa fa-sort"></i></a></th>
                            <th scope="col"><?php esc_attr_e('Job', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('job');"><i class="fa fa-user-plus"></i></a></th>
                            <th scope="col"><?php esc_attr_e('Email', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('two_email');"><i class="fa fa-sort"></i></a></th>
                            <th scope="col"><?php esc_attr_e('Phone', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('two_phone');"><i class="fa fa-sort"></i></a></th>							
                            <th scope="col"><?php esc_attr_e('Web', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('web');"><i class="fa fa-sort"></i></a></th>
                            <th scope="col"><?php esc_attr_e('Address', $this->text_domain); ?>&nbsp;<a ng-click="sort_by('two_address');"><i class="fa fa-sort"></i></a></th>                 
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <tr ng-repeat="data in filtered = (people| filter:search | orderBy : predicate :reverse) | startFrom:(currentPage - 1) * entryLimit | limitTo:entryLimit">
                        	<td><img src="{{data.image}}" height="32px" target="_blank"/></td>
                            <td>{{data.name}}</td>
                            <td>{{data.lastname}}</td>
                            <td>{{data.email}}</td>
                            <td>{{data.phone}}</td>
                            <td>{{data.company}}</td>							
                            <td>{{data.two_email}}</td>
                            <td>{{data.two_phone}}</td>			
					        <td>{{data.job}}</td>
                            <td>{{data.web}}</td> 
							<td>{{data.two_address}}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="total-item">
                    <span>Filtered {{ filtered.length}} of {{ totalItems}} total customers</span>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
wp_enqueue_script('ui-bootstrap-tpls-min-js'); ?>